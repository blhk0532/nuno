#!/usr/bin/env node

/**
 * Ratsit.se Queue Processor
 * - Fetches queued records from ratsit_data table (is_queued = true)
 * - Scrapes additional person data from Ratsit.se for each queued record
 * - Updates records with enriched Ratsit data
 * - Sets is_queued = false when processing is complete
 */

import { program } from 'commander';
import { promises as fs } from 'fs';
import path from 'path';
import { chromium } from 'playwright';
import axios from 'axios';
import Database from 'better-sqlite3';

class RatsitScraper {
  constructor(api_url, api_token) {
    this.api_url = api_url || process.env.LARAVEL_API_URL || process.env.APP_URL;
    this.api_token = api_token || process.env.LARAVEL_API_TOKEN;

    this.data_dir = path.join(process.cwd(), 'scripts', 'data');

    // Define unwanted text patterns to filter out
    this.unwantedPatterns = [
      /DOLT - Bli validerad medlem för att se/gi,
      /Kolla lön direkt/gi
    ];

    // Ensure data directory exists
    fs.mkdir(this.data_dir, { recursive: true }).catch(() => {});

    // Initialize SQLite databases
    this.initSQLiteDatabases();
    this.prepareSQLiteStatements();
  }

  /**
   * Filter out unwanted text patterns from a string
   * @param {string} text - The text to filter
   * @returns {string} - The filtered text
   */
  filterUnwantedText(text) {
    if (!text || typeof text !== 'string') return text;
    let filtered = text;
    for (const pattern of this.unwantedPatterns) {
      filtered = filtered.replace(pattern, '');
    }
    return filtered.trim();
  }

  /**
   * Check if text contains any unwanted patterns
   * @param {string} text - The text to check
   * @returns {boolean} - True if text contains unwanted patterns
   */
  containsUnwantedText(text) {
    if (!text || typeof text !== 'string') return false;
    return this.unwantedPatterns.some(pattern => pattern.test(text));
  }

  /**
   * Filter array of extraction results (objects with text property)
   * @param {Array} items - Array of items with text property
   * @returns {Array} - Filtered array
   */
  filterExtractionResults(items) {
    if (!Array.isArray(items)) return items;
    return items
      .map(item => {
        if (typeof item === 'string') {
          return this.filterUnwantedText(item);
        } else if (item && typeof item === 'object' && item.text) {
          return {
            ...item,
            text: this.filterUnwantedText(item.text)
          };
        }
        return item;
      })
      .filter(item => {
        if (typeof item === 'string') {
          return item !== '' && !this.containsUnwantedText(item);
        } else if (item && typeof item === 'object' && item.text) {
          return item.text !== '' && !this.containsUnwantedText(item.text);
        }
        return true;
      });
  }

  initSQLiteDatabases() {
    try {
      // Database paths
      const dbDir = path.join(process.cwd(), 'database');
      const ratsitDbPath = path.join(dbDir, 'ratsit.sqlite');
      const personerDbPath = path.join(dbDir, 'personer.sqlite');

      // Ensure database directory exists
      fs.mkdir(dbDir, { recursive: true }).catch(() => {});

      // Initialize ratsit.sqlite
      this.ratsitDb = new Database(ratsitDbPath);
      this.ratsitDb.exec(`
        CREATE TABLE IF NOT EXISTS ratsit_data (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          personnummer TEXT UNIQUE,
          personnamn TEXT,
          gatuadress TEXT,
          postnummer TEXT,
          postort TEXT,
          forsamling TEXT,
          kommun TEXT,
          kommun_ratsit TEXT,
          lan TEXT,
          adressandring TEXT,
          telfonnummer TEXT,
          stjarntacken TEXT,
          fodelsedag TEXT,
          alder TEXT,
          kon TEXT,
          civilstand TEXT,
          fornamn TEXT,
          efternamn TEXT,
          telefon TEXT,
          epost_adress TEXT,
          agandeform TEXT,
          bostadstyp TEXT,
          boarea TEXT,
          byggar TEXT,
          fastighet TEXT,
          personer TEXT,
          foretag TEXT,
          grannar TEXT,
          fordon TEXT,
          hundar TEXT,
          bolagsengagemang TEXT,
          longitude TEXT,
          latitud TEXT,
          google_maps TEXT,
          google_streetview TEXT,
          ratsit_se TEXT,
          is_active INTEGER DEFAULT 1,
          ratsit_created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          ratsit_updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        CREATE INDEX IF NOT EXISTS idx_personnummer ON ratsit_data(personnummer);
        CREATE INDEX IF NOT EXISTS idx_personnamn ON ratsit_data(personnamn);
      `);

      // Initialize personer.sqlite (should already exist, but ensure ratsit_data_id column)
      this.personerDb = new Database(personerDbPath);
      this.personerDb.exec(`
        CREATE TABLE IF NOT EXISTS personer_data (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          personnamn TEXT,
          gatuadress TEXT,
          postnummer TEXT,
          postort TEXT,
          ratsit_data_id INTEGER,
          ratsit_gatuadress TEXT,
          ratsit_postnummer TEXT,
          ratsit_postort TEXT,
          ratsit_forsamling TEXT,
          ratsit_kommun TEXT,
          ratsit_lan TEXT,
          ratsit_adressandring TEXT,
          ratsit_kommun_ratsit TEXT,
          ratsit_stjarntacken TEXT,
          ratsit_fodelsedag TEXT,
          ratsit_personnummer TEXT,
          ratsit_alder TEXT,
          ratsit_kon TEXT,
          ratsit_civilstand TEXT,
          ratsit_fornamn TEXT,
          ratsit_efternamn TEXT,
          ratsit_personnamn TEXT,
          ratsit_agandeform TEXT,
          ratsit_bostadstyp TEXT,
          ratsit_boarea TEXT,
          ratsit_byggar TEXT,
          ratsit_fastighet TEXT,
          ratsit_telfonnummer TEXT,
          ratsit_epost_adress TEXT,
          ratsit_personer TEXT,
          ratsit_foretag TEXT,
          ratsit_grannar TEXT,
          ratsit_fordon TEXT,
          ratsit_hundar TEXT,
          ratsit_bolagsengagemang TEXT,
          ratsit_longitude TEXT,
          ratsit_latitud TEXT,
          ratsit_google_maps TEXT,
          ratsit_google_streetview TEXT,
          ratsit_ratsit_se TEXT,
          ratsit_is_active INTEGER DEFAULT 1,
          ratsit_updated_at DATETIME,
          is_active INTEGER DEFAULT 1,
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
          updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
      `);
      // Add ratsit_data_id column if it doesn't exist
      try {
        this.personerDb.exec(`ALTER TABLE personer_data ADD COLUMN ratsit_data_id INTEGER;`);
      } catch (e) {
        // Column might already exist, ignore error
      }
      // Add all ratsit columns if they don't exist
      const ratsitColumns = [
        'ratsit_gatuadress', 'ratsit_postnummer', 'ratsit_postort', 'ratsit_forsamling',
        'ratsit_kommun', 'ratsit_lan', 'ratsit_adressandring', 'ratsit_kommun_ratsit',
        'ratsit_stjarntacken', 'ratsit_fodelsedag', 'ratsit_personnummer', 'ratsit_alder',
        'ratsit_kon', 'ratsit_civilstand', 'ratsit_fornamn', 'ratsit_efternamn',
        'ratsit_personnamn', 'ratsit_agandeform', 'ratsit_bostadstyp', 'ratsit_boarea',
        'ratsit_byggar', 'ratsit_fastighet', 'ratsit_telfonnummer', 'ratsit_epost_adress',
        'ratsit_personer', 'ratsit_foretag', 'ratsit_grannar', 'ratsit_fordon',
        'ratsit_hundar', 'ratsit_bolagsengagemang', 'ratsit_longitude', 'ratsit_latitud',
        'ratsit_google_maps', 'ratsit_google_streetview', 'ratsit_ratsit_se', 'ratsit_is_active',
        'ratsit_updated_at'
      ];
      for (const col of ratsitColumns) {
        try {
          this.personerDb.exec(`ALTER TABLE personer_data ADD COLUMN ${col} TEXT;`);
        } catch (e) {
          // Column might already exist, ignore error
        }
      }
      this.personerDb.exec(`CREATE INDEX IF NOT EXISTS idx_ratsit_data_id ON personer_data(ratsit_data_id);`);

      console.log('✅ SQLite databases initialized for Ratsit scraper');
    } catch (error) {
      console.error('❌ Failed to initialize SQLite databases:', error.message);
      throw error;
    }
  }

  prepareSQLiteStatements() {
    // ratsit_data upsert statement - simplified
    this.ratsitUpsertStmt = this.ratsitDb.prepare(`
      INSERT OR REPLACE INTO ratsit_data
      (personnummer, personnamn, gatuadress)
      VALUES (?, ?, ?)
    `);

    // personer_data ratsit fields update statement
    this.personerRatsitUpdateStmt = this.personerDb.prepare(`
      UPDATE personer_data SET
        ratsit_data_id = ?,
        ratsit_gatuadress = ?,
        ratsit_postnummer = ?,
        ratsit_postort = ?,
        ratsit_forsamling = ?,
        ratsit_kommun = ?,
        ratsit_lan = ?,
        ratsit_adressandring = ?,
        ratsit_kommun_ratsit = ?,
        ratsit_stjarntacken = ?,
        ratsit_fodelsedag = ?,
        ratsit_personnummer = ?,
        ratsit_alder = ?,
        ratsit_kon = ?,
        ratsit_civilstand = ?,
        ratsit_fornamn = ?,
        ratsit_efternamn = ?,
        ratsit_personnamn = ?,
        ratsit_agandeform = ?,
        ratsit_bostadstyp = ?,
        ratsit_boarea = ?,
        ratsit_byggar = ?,
        ratsit_fastighet = ?,
        ratsit_telfonnummer = ?,
        ratsit_epost_adress = ?,
        ratsit_personer = ?,
        ratsit_foretag = ?,
        ratsit_grannar = ?,
        ratsit_fordon = ?,
        ratsit_hundar = ?,
        ratsit_bolagsengagemang = ?,
        ratsit_longitude = ?,
        ratsit_latitud = ?,
        ratsit_google_maps = ?,
        ratsit_google_streetview = ?,
        ratsit_ratsit_se = ?,
        ratsit_is_active = ?,
        ratsit_updated_at = ?
      WHERE personnamn = ? AND gatuadress = ?
    `);
  }

  async saveRatsitToDatabase(ratsitData) {
    /**
     * Save Ratsit data to SQLite first, then to API, then to personer_data
     */
    try {
      const now = new Date().toISOString();

      // Prepare data for SQLite
      const sqliteData = {
        personnummer: ratsitData.ps_personnummer || null,
        personnamn: ratsitData.ps_personnamn || null,
        gatuadress: ratsitData.bo_gatuadress || null,
        postnummer: ratsitData.bo_postnummer || null,
        postort: ratsitData.bo_postort || null,
        forsamling: ratsitData.bo_forsamling || null,
        kommun: ratsitData.bo_kommun || null,
        kommun_ratsit: ratsitData.kommun_ratsit || null,
        lan: ratsitData.bo_lan || null,
        adressandring: ratsitData.adressandring || null,
        telfonnummer: Array.isArray(ratsitData.telefonnummer) ? ratsitData.telefonnummer.join(' | ') : null,
        stjarntacken: ratsitData.stjarntacken || null,
        fodelsedag: ratsitData.ps_fodelsedag || null,
        alder: ratsitData.ps_alder || null,
        kon: ratsitData.ps_kon || null,
        civilstand: ratsitData.ps_civilstand || null,
        fornamn: ratsitData.ps_fornamn || null,
        efternamn: ratsitData.ps_efternamn || null,
        telefon: ratsitData.ps_telefon || null,
        epost_adress: Array.isArray(ratsitData.epost_adress) ? ratsitData.epost_adress.join(' | ') : null,
        agandeform: ratsitData.bo_agandeform || null,
        bostadstyp: ratsitData.bo_bostadstyp || null,
        boarea: ratsitData.bo_boarea || null,
        byggar: ratsitData.bo_byggar || null,
        fastighet: ratsitData.bo_fastighet || null,
        personer: Array.isArray(ratsitData.bo_personer) ? JSON.stringify(ratsitData.bo_personer) : null,
        foretag: Array.isArray(ratsitData.bo_foretag) ? JSON.stringify(ratsitData.bo_foretag) : null,
        grannar: Array.isArray(ratsitData.bo_grannar) ? JSON.stringify(ratsitData.bo_grannar) : null,
        fordon: Array.isArray(ratsitData.bo_fordon) ? JSON.stringify(ratsitData.bo_fordon) : null,
        hundar: Array.isArray(ratsitData.bo_hundar) ? JSON.stringify(ratsitData.bo_hundar) : null,
        bolagsengagemang: Array.isArray(ratsitData.ps_bolagsengagemang) ? JSON.stringify(ratsitData.ps_bolagsengagemang) : null,
        longitude: ratsitData.bo_longitude || null,
        latitud: ratsitData.latitud || null,
        google_maps: ratsitData.google_maps || null,
        google_streetview: ratsitData.google_streetview || null,
        ratsit_se: ratsitData.ratsit_se || null,
        is_active: 1,
        ratsit_created_at: now,
        ratsit_updated_at: now,
      };

      // Save to ratsit_data SQLite first
      let ratsitId = null;
      try {
        const result = this.ratsitUpsertStmt.run(
          sqliteData.personnummer, sqliteData.personnamn, sqliteData.gatuadress
        );
        ratsitId = result.lastInsertRowid || this.ratsitDb.prepare('SELECT id FROM ratsit_data WHERE personnummer = ?').get(sqliteData.personnummer)?.id;
        console.log(`  💾 Saved Ratsit data to SQLite (ID: ${ratsitId})`);
      } catch (sqliteErr) {
        console.error(`  ❌ SQLite ratsit_data error:`, sqliteErr.message);
      }

      const apiData = {
        gatuadress: ratsitData.bo_gatuadress || null,
        postnummer: ratsitData.bo_postnummer || null,
        postort: ratsitData.bo_postort || null,
        forsamling: ratsitData.bo_forsamling || null,
        kommun: ratsitData.bo_kommun || null,
        kommun_ratsit: ratsitData.kommun_ratsit || null,
        lan: ratsitData.bo_lan || null,
        adressandring: ratsitData.adressandring || null,
        telfonnummer: Array.isArray(ratsitData.telefonnummer) ? ratsitData.telefonnummer.join(' | ') : null,
        stjarntacken: ratsitData.stjarntacken || null,
        fodelsedag: ratsitData.ps_fodelsedag || null,
        personnummer: ratsitData.ps_personnummer || null,
        alder: ratsitData.ps_alder || null,
        kon: ratsitData.ps_kon || null,
        civilstand: ratsitData.ps_civilstand || null,
        fornamn: ratsitData.ps_fornamn || null,
        efternamn: ratsitData.ps_efternamn || null,
        personnamn: ratsitData.ps_personnamn || null,
        telefon: ratsitData.ps_telefon || null,
        agandeform: ratsitData.bo_agandeform || null,
        bostadstyp: ratsitData.bo_bostadstyp || null,
        boarea: ratsitData.bo_boarea || null,
        byggar: ratsitData.bo_byggar || null,
        personer: Array.isArray(ratsitData.bo_personer) ? ratsitData.bo_personer.map(p => typeof p === 'object' ? p.text : p) : null,
        foretag: Array.isArray(ratsitData.bo_foretag) ? ratsitData.bo_foretag.map(f => typeof f === 'object' ? f.text : f) : null,
        grannar: Array.isArray(ratsitData.bo_grannar) ? ratsitData.bo_grannar.map(g => typeof g === 'object' ? g.text : g) : null,
        fordon: Array.isArray(ratsitData.bo_fordon) ? ratsitData.bo_fordon.map(f => typeof f === 'object' ? f.text : f) : null,
        hundar: Array.isArray(ratsitData.bo_hundar) ? ratsitData.bo_hundar.map(h => typeof h === 'object' ? h.text : h) : null,
        bolagsengagemang: Array.isArray(ratsitData.ps_bolagsengagemang) ? ratsitData.ps_bolagsengagemang.map(b => typeof b === 'object' ? b.text : b) : null,
        longitude: ratsitData.bo_longitude || null,
        latitud: ratsitData.latitud || null,
        google_maps: ratsitData.google_maps || null,
        google_streetview: ratsitData.google_streetview || null,
        ratsit_se: ratsitData.ratsit_se || null,
        is_active: true,
      };

      // Log what we're about to send to API
      console.log('\n  📤 API Payload for ratsit_data:');
      const nonNullFields = Object.entries(apiData).filter(([k, v]) => v !== null);
      console.log(`     Sending ${nonNullFields.length} non-null fields out of ${Object.keys(apiData).length} total`);
      nonNullFields.forEach(([key, value]) => {
        let display;
        if (Array.isArray(value)) {
          if (value.length === 0) {
            display = '[]';
          } else if (typeof value[0] === 'object' && value[0] !== null) {
            // Array of objects - show count and sample
            display = `[${value.length} objects: ${value.slice(0, 2).map(obj => obj.text || '[object]').join(', ')}${value.length > 2 ? '...' : ''}]`;
          } else {
            // Array of primitives
            display = JSON.stringify(value);
          }
        } else if (typeof value === 'string' && value.length > 60) {
          display = value.substring(0, 60) + '...';
        } else {
          display = value;
        }
        console.log(`     ${key}: ${display}`);
      });
      console.log('');

      // Use API to save to ratsit_data
      const response = await axios.post(`${this.api_url}/api/ratsit-data/bulk`, { records: [apiData] }, {
        headers: {
          'Content-Type': 'application/json',
          // Authorization may not be required for bulk but include if token supplied
          'Authorization': this.api_token ? `Bearer ${this.api_token}` : undefined,
        },
      });

      console.log(`  ✓ Saved Ratsit data for ${ratsitData.ps_personnamn} to ratsit_data via API`);
      console.log(`  ✓ API Response:`, JSON.stringify(response.data, null, 2));

      // Now save to personer_data with ratsit_data_id
      // DISABLED: personer_data saves are disabled by user request
      /*
      if (ratsitId && ratsitData.ps_personnamn && ratsitData.bo_gatuadress) {
        try {
          const personerApiData = {
            personnamn: ratsitData.ps_personnamn,
            gatuadress: ratsitData.bo_gatuadress,
            postnummer: ratsitData.bo_postnummer || null,
            postort: ratsitData.bo_postort || null,
            ratsit_data_id: ratsitId,
            // Include all ratsit fields
            ratsit_gatuadress: ratsitData.bo_gatuadress || null,
            ratsit_postnummer: ratsitData.bo_postnummer || null,
            ratsit_postort: ratsitData.bo_postort || null,
            ratsit_forsamling: ratsitData.bo_forsamling || null,
            ratsit_kommun: ratsitData.bo_kommun || null,
            ratsit_lan: ratsitData.bo_lan || null,
            ratsit_adressandring: ratsitData.adressandring || null,
            ratsit_kommun_ratsit: ratsitData.kommun_ratsit || null,
            ratsit_stjarntacken: ratsitData.stjarntacken || null,
            ratsit_fodelsedag: ratsitData.ps_fodelsedag || null,
            ratsit_personnummer: ratsitData.ps_personnummer || null,
            ratsit_alder: ratsitData.ps_alder || null,
            ratsit_kon: ratsitData.ps_kon || null,
            ratsit_civilstand: ratsitData.ps_civilstand || null,
            ratsit_fornamn: ratsitData.ps_fornamn || null,
            ratsit_efternamn: ratsitData.ps_efternamn || null,
            ratsit_personnamn: ratsitData.ps_personnamn || null,
            ratsit_agandeform: ratsitData.bo_agandeform || null,
            ratsit_bostadstyp: ratsitData.bo_bostadstyp || null,
            ratsit_boarea: ratsitData.bo_boarea || null,
            ratsit_byggar: ratsitData.bo_byggar || null,
            ratsit_fastighet: ratsitData.bo_fastighet || null,
            ratsit_telfonnummer: Array.isArray(ratsitData.telefonnummer) ? ratsitData.telefonnummer : null,
            ratsit_epost_adress: Array.isArray(ratsitData.epost_adress) ? ratsitData.epost_adress : null,
            ratsit_personer: Array.isArray(ratsitData.bo_personer) ? ratsitData.bo_personer.map(p => typeof p === 'object' ? p.text : p) : null,
            ratsit_foretag: Array.isArray(ratsitData.bo_foretag) ? ratsitData.bo_foretag.map(f => typeof f === 'object' ? f.text : f) : null,
            ratsit_grannar: Array.isArray(ratsitData.bo_grannar) ? ratsitData.bo_grannar.map(g => typeof g === 'object' ? g.text : g) : null,
            ratsit_fordon: Array.isArray(ratsitData.bo_fordon) ? ratsitData.bo_fordon.map(f => typeof f === 'object' ? f.text : f) : null,
            ratsit_hundar: Array.isArray(ratsitData.bo_hundar) ? ratsitData.bo_hundar.map(h => typeof h === 'object' ? h.text : h) : null,
            ratsit_bolagsengagemang: Array.isArray(ratsitData.ps_bolagsengagemang) ? ratsitData.ps_bolagsengagemang.map(b => typeof b === 'object' ? b.text : b) : null,
            ratsit_longitude: ratsitData.bo_longitude || null,
            ratsit_latitud: ratsitData.latitud || null,
            ratsit_google_maps: ratsitData.google_maps || null,
            ratsit_google_streetview: ratsitData.google_streetview || null,
            ratsit_ratsit_se: ratsitData.ratsit_se || null,
            ratsit_is_active: true,
            ratsit_updated_at: now,
            is_active: true,
          };

          const personerResponse = await axios.post(`${this.api_url}/api/personer-data/bulk`, { records: [personerApiData] }, {
            headers: {
              'Content-Type': 'application/json',
              'Authorization': this.api_token ? `Bearer ${this.api_token}` : undefined,
            },
          });

          console.log(`  ✓ Saved Ratsit data to personer_data via API (ratsit_data_id: ${ratsitId})`);
          console.log(`  ✓ Personer API Response:`, JSON.stringify(personerResponse.data, null, 2));

          // Update personer_data in SQLite
          try {
            this.personerRatsitUpdateStmt.run(
              ratsitId, // ratsit_data_id
              personerApiData.ratsit_gatuadress,
              personerApiData.ratsit_postnummer,
              personerApiData.ratsit_postort,
              personerApiData.ratsit_forsamling,
              personerApiData.ratsit_kommun,
              personerApiData.ratsit_lan,
              personerApiData.ratsit_adressandring,
              personerApiData.ratsit_kommun_ratsit,
              personerApiData.ratsit_stjarntacken,
              personerApiData.ratsit_fodelsedag,
              personerApiData.ratsit_personnummer,
              personerApiData.ratsit_alder,
              personerApiData.ratsit_kon,
              personerApiData.ratsit_civilstand,
              personerApiData.ratsit_fornamn,
              personerApiData.ratsit_efternamn,
              personerApiData.ratsit_personnamn,
              personerApiData.ratsit_agandeform,
              personerApiData.ratsit_bostadstyp,
              personerApiData.ratsit_boarea,
              personerApiData.ratsit_byggar,
              personerApiData.ratsit_fastighet,
              JSON.stringify(personerApiData.ratsit_telfonnummer || []),
              JSON.stringify(personerApiData.ratsit_epost_adress || []),
              JSON.stringify(personerApiData.ratsit_personer || []),
              JSON.stringify(personerApiData.ratsit_foretag || []),
              JSON.stringify(personerApiData.ratsit_grannar || []),
              JSON.stringify(personerApiData.ratsit_fordon || []),
              JSON.stringify(personerApiData.ratsit_hundar || []),
              JSON.stringify(personerApiData.ratsit_bolagsengagemang || []),
              personerApiData.ratsit_longitude,
              personerApiData.ratsit_latitud,
              personerApiData.ratsit_google_maps,
              personerApiData.ratsit_google_streetview,
              personerApiData.ratsit_ratsit_se,
              personerApiData.ratsit_is_active ? 1 : 0,
              now, // ratsit_updated_at
              personerApiData.personnamn,
              personerApiData.gatuadress
            );
            console.log(`  💾 Updated personer_data in SQLite with ratsit data`);
          } catch (personerSqliteErr) {
            console.error(`  ❌ SQLite personer_data update error:`, personerSqliteErr.message);
          }

        } catch (personerErr) {
          console.error(`  ❌ Error saving to personer_data API:`, personerErr.response?.data || personerErr.message);
        }
      } else {
        console.log(`  ⚠️ Skipping personer_data save (missing ratsitId, personnamn, or gatuadress)`);
      }
      */

      return true;
    } catch (error) {
      const status = error.response?.status;
      console.log(`  ✗ Error saving Ratsit data via API${status ? ` (HTTP ${status})` : ''}:`, error.response?.data || error.message);
      return false;
    }
  }

  // async updateHittaDataRatsitFlag(ratsitData) {
  //   /**
  //    * Update is_ratsit flag in hitta_data via API (no local SQLite dependency)
  //    * COMMENTED OUT: This method saves data to hitta_data table, which we don't want
  //    */
  //   try {
  //     const personnamn = ratsitData.ps_personnamn || ratsitData.personnamn || null;
  //     const gatuadress = ratsitData.bo_gatuadress || ratsitData.gatuadress || null;
  //     if (!personnamn || !gatuadress) {
  //       console.log('  ⚠ Skipping hitta_data flag update (missing personnamn or gatuadress)');
  //       return;
  //     }

  //     // Use bulk upsert by personnamn; include gatuadress for better matching and set is_ratsit
  //     const payload = { records: [{ personnamn, gatuadress, is_ratsit: true }] };
  //     await axios.post(`${this.api_url}/api/hitta-data/bulk`, payload, {
  //       headers: {
  //         'Content-Type': 'application/json',
  //         'Authorization': this.api_token ? `Bearer ${this.api_token}` : undefined,
  //       },
  //     });

  //     console.log(`  ✓ Updated is_ratsit flag in hitta_data via API`);
  //   } catch (error) {
  //     const status = error.response?.status;
  //     console.log(`  ✗ Error updating hitta_data is_ratsit flag via API${status ? ` (HTTP ${status})` : ''}:`, error.response?.data || error.message);
  //   }
  // }

  async saveToPrivateData(hittaData, ratsitData) {
    /**
     * Save combined Hitta + Ratsit data to private_data table via API
     * Only saves if BOTH hitta and ratsit data are available
     */
    if (!hittaData || !ratsitData) {
      console.log('  ⊘ Skipping private_data save (need both Hitta and Ratsit data)');
      return false;
    }

    try {
      // Combine data from both sources
      const apiData = {
        // Address fields (prefer Ratsit)
        gatuadress: ratsitData.bo_gatuadress || hittaData.gatuadress || null,
        postnummer: ratsitData.bo_postnummer || hittaData.postnummer || null,
        postort: ratsitData.bo_postort || hittaData.postort || null,
        forsamling: ratsitData.bo_forsamling || null,
        kommun: ratsitData.bo_kommun || null,
        kommun_ratsit: ratsitData.kommun_ratsit || null,
        lan: ratsitData.bo_lan || null,
        adressandring: ratsitData.adressandring || null,

        // Phone arrays (send as arrays, not JSON strings)
        telefon: Array.isArray(ratsitData.ps_telefon) ? ratsitData.ps_telefon : (Array.isArray(hittaData.telefon) ? hittaData.telefon : []),

        // Person fields (Ratsit)
        stjarntacken: ratsitData.stjarntacken || null,
        fodelsedag: ratsitData.ps_fodelsedag || null,
        personnummer: ratsitData.ps_personnummer || null,
        alder: ratsitData.ps_alder || hittaData.alder || null,
        kon: ratsitData.ps_kon || hittaData.kon || null,
        civilstand: ratsitData.ps_civilstand || null,
        fornamn: ratsitData.ps_fornamn || null,
        efternamn: ratsitData.ps_efternamn || null,
        personnamn: ratsitData.ps_personnamn || hittaData.personnamn || null,

        // Dwelling fields (Ratsit)
        agandeform: ratsitData.bo_agandeform || null,
        bostadstyp: ratsitData.bo_bostadstyp || null,
        boarea: ratsitData.bo_boarea || null,
        byggar: ratsitData.bo_byggar || null,

        // Collections (Ratsit) - send as arrays
        personer: Array.isArray(ratsitData.bo_personer) ? ratsitData.bo_personer : [],
        foretag: Array.isArray(ratsitData.bo_foretag) ? ratsitData.bo_foretag : [],
        grannar: Array.isArray(ratsitData.bo_grannar) ? ratsitData.bo_grannar : [],
        fordon: Array.isArray(ratsitData.bo_fordon) ? ratsitData.bo_fordon : [],
        hundar: Array.isArray(ratsitData.bo_hundar) ? ratsitData.bo_hundar : [],
        bolagsengagemang: Array.isArray(ratsitData.ps_bolagsengagemang) ? ratsitData.ps_bolagsengagemang : [],

        // Geo & Links (combined)
        longitude: ratsitData.bo_longitude || null,
        latitud: ratsitData.latitud || null,
        google_maps: ratsitData.google_maps || null,
        google_streetview: ratsitData.google_streetview || null,

        // Hitta specific fields
        hitta_link: hittaData.link || null,
        hitta_karta: hittaData.karta || null,
        bostad_typ: hittaData.bostadstyp || null,
        bostad_pris: hittaData.bostadspris || null,

        // Flags
        is_active: true,
      };

      // Use API to save
      const response = await axios.post(`${this.api_url}/api/data-private/bulk`, { records: [apiData] }, {
        headers: {
          'Content-Type': 'application/json',
          'Authorization': this.api_token ? `Bearer ${this.api_token}` : undefined,
        },
      });

      console.log(`  ✓ Combined data saved to private_data via API:`, response.data);
      return true;
    } catch (error) {
      console.log(`  ✗ Error saving combined data via API:`, error.response?.data || error.message);
      return false;
    }
  }

  /**
   * Fetch queued records from ratsit_data table via API
   * @param {number} limit - Maximum number of records to fetch
   * @param {string} postnummer - Optional postnummer filter
   * @returns {Promise<Array>} Array of queued records
   */
  async fetchQueuedRecords(limit = 100000, postnummer = null) {
    try {
      let apiUrl = `${this.api_url}/api/ratsit-data?is_queued=true&per_page=${limit}&sort_by=created_at&sort_direction=desc`;

      // Add postnummer filter if provided
      if (postnummer) {
        apiUrl += `&postnummer=${encodeURIComponent(postnummer)}`;
      }

      console.log(`  📡 Fetching queued records from: ${apiUrl}`);

      const response = await axios.get(apiUrl, {
        headers: {
          'Accept': 'application/json'
        },
        timeout: 30000
      });

      if (response.status === 200 && response.data && response.data.data) {
        const records = response.data.data;
        console.log(`  ✅ Found ${records.length} queued record(s)`);
        return records;
      } else {
        console.log(`  ⚠️  Unexpected API response: ${response.status}`);
        return [];
      }
    } catch (error) {
      console.error(`  ❌ Error fetching queued records:`, error.response?.data || error.message);
      return [];
    }
  }

  /**
   * Update a ratsit_data record with scraped Ratsit data and mark as processed
   * @param {number} recordId - The ID of the record to update
   * @param {Object} ratsitData - The scraped Ratsit data
   * @returns {Promise<boolean>} Success status
   */
  async updateRecordWithRatsitData(recordId, ratsitData) {
    try {
      // Prepare the update payload with Ratsit data
      const updateData = {
        gatuadress: ratsitData.bo_gatuadress || null,
        postnummer: ratsitData.bo_postnummer || null,
        postort: ratsitData.bo_postort || null,
        forsamling: ratsitData.bo_forsamling || null,
        kommun: ratsitData.bo_kommun || null,
        kommun_ratsit: ratsitData.kommun_ratsit || null,
        lan: ratsitData.bo_lan || null,
        adressandring: ratsitData.adressandring || null,
        telfonnummer: Array.isArray(ratsitData.telefonnummer) ? ratsitData.telefonnummer.join('|') : null,
        stjarntacken: ratsitData.stjarntacken || null,
        // Handle fodelsedag - try scraped value first, then derive from personnummer
        fodelsedag: (() => {
          let fodelsedag = ratsitData.ps_fodelsedag || null;
          if (fodelsedag) {
            // If it's in Swedish format like "3 oktober 1966", convert to ISO format
            const swedishDateMatch = fodelsedag.match(/^(\d{1,2})\s+(\w+)\s+(\d{4})$/);
            if (swedishDateMatch) {
              const day = swedishDateMatch[1].padStart(2, '0');
              const monthName = swedishDateMatch[2].toLowerCase();
              const year = swedishDateMatch[3];

              // Swedish month names to numbers
              const monthMap = {
                'januari': '01', 'februari': '02', 'mars': '03', 'april': '04',
                'maj': '05', 'juni': '06', 'juli': '07', 'augusti': '08',
                'september': '09', 'oktober': '10', 'november': '11', 'december': '12'
              };

              const month = monthMap[monthName];
              if (month) {
                fodelsedag = `${year}-${month}-${day}`;
                console.log(`  📅 Converted Swedish date to ISO: ${fodelsedag}`);
              }
            }
          }
          if (!fodelsedag && ratsitData.ps_personnummer) {
            // Extract date from personnummer (format: YYYYMMDD-XXXX)
            const personnummerMatch = ratsitData.ps_personnummer.match(/^(\d{4})(\d{2})(\d{2})/);
            if (personnummerMatch) {
              fodelsedag = `${personnummerMatch[1]}-${personnummerMatch[2]}-${personnummerMatch[3]}`;
              console.log(`  📅 Derived fodelsedag from personnummer: ${fodelsedag}`);
            }
          }
          if (fodelsedag) {
            console.log(`  📅 Using fodelsedag: ${fodelsedag}`);
          }
          return fodelsedag;
        })(),
        personnummer: ratsitData.ps_personnummer || null,
        alder: ratsitData.ps_alder || null,
        kon: ratsitData.ps_kon || null,
        civilstand: ratsitData.ps_civilstand || null,
        fornamn: ratsitData.ps_fornamn || null,
        efternamn: ratsitData.ps_efternamn || null,
        personnamn: ratsitData.ps_personnamn || null,
        telefon: ratsitData.ps_telefon || null,
        agandeform: ratsitData.bo_agandeform || null,
        bostadstyp: ratsitData.bo_bostadstyp || null,
        boarea: ratsitData.bo_boarea || null,
        byggar: ratsitData.bo_byggar || null,
        personer: Array.isArray(ratsitData.bo_personer) ? ratsitData.bo_personer.map(p => typeof p === 'object' ? p.text : p) : null,
        foretag: Array.isArray(ratsitData.bo_foretag) ? ratsitData.bo_foretag.map(f => typeof f === 'object' ? f.text : f) : null,
        grannar: Array.isArray(ratsitData.bo_grannar) ? ratsitData.bo_grannar.map(g => typeof g === 'object' ? g.text : g) : null,
        fordon: Array.isArray(ratsitData.bo_fordon) ? ratsitData.bo_fordon.map(f => typeof f === 'object' ? f.text : f) : null,
        hundar: Array.isArray(ratsitData.bo_hundar) ? ratsitData.bo_hundar.map(h => typeof h === 'object' ? h.text : h) : null,
        bolagsengagemang: Array.isArray(ratsitData.ps_bolagsengagemang) ? ratsitData.ps_bolagsengagemang.map(b => typeof b === 'object' ? b.text : b) : null,
        longitude: ratsitData.bo_longitude || null,
        latitud: ratsitData.latitud || null,
        google_maps: ratsitData.google_maps || null,
        google_streetview: ratsitData.google_streetview || null,
        ratsit_se: ratsitData.ratsit_se || null,
        is_hus: ratsitData.bo_agandeform === 'Äganderätt' || ratsitData.bo_agandeform === 'Tomträtt',
        is_telefon: ratsitData.ps_telefon && ratsitData.ps_telefon.trim() !== '',
        is_queued: false, // Mark as processed
      };

      const apiUrl = `${this.api_url}/api/ratsit-data/${recordId}`;

      console.log(`  � Debug arrays:`);
      console.log(`  📤 Updating record ${recordId} via API`);

      const response = await axios.put(apiUrl, updateData, {
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        timeout: 30000,
        maxRedirects: 0, // Don't follow redirects
        validateStatus: function (status) {
          return status >= 200 && status < 400; // Accept 2xx and 3xx
        }
      });

      if (response.status === 200) {
        console.log(` 𐦂𖨆𐀪𖠋𐀪𐀪 ✅ Successfully updated record ${recordId}`);
        return true;
      } else {
        console.log(`  ⚠️  Unexpected update response: ${response.status}`);
        return false;
      }
    } catch (error) {
      const errData = error.response?.data || error.message || '';
      console.error(`  ❌ Error updating record ${recordId}:`, errData);

      // Detect duplicate key error messages (MySQL/SQL states) and try to update the existing record
      const isDuplicateError = (typeof errData === 'string' && errData.includes('Duplicate entry')) ||
        (errData && typeof errData.message === 'string' && errData.message.includes('Duplicate entry')) ||
        (errData && errData.exception && JSON.stringify(errData.exception).includes('Duplicate entry'));

      if (isDuplicateError && updateData.personnamn && updateData.gatuadress) {
        try {
          console.log(`  🔎 Duplicate error detected — searching for existing record to update for ${updateData.personnamn} @ ${updateData.gatuadress}`);

          const searchUrl = `${this.api_url}/api/ratsit-data?personnamn=${encodeURIComponent(updateData.personnamn)}&per_page=100`;
          const searchResp = await axios.get(searchUrl, {
            headers: { 'Accept': 'application/json', ...(this.api_token && { 'Authorization': `Bearer ${this.api_token}` }) },
            timeout: 20000,
          });

          if (searchResp?.status === 200 && searchResp.data && Array.isArray(searchResp.data.data)) {
            const matches = searchResp.data.data.filter(r => (r.personnamn || '').trim() === (updateData.personnamn || '').trim());
            const exactMatch = matches.find(r => (r.gatuadress || '').trim() === (updateData.gatuadress || '').trim());

            if (exactMatch) {
              console.log(`  🔁 Found existing duplicate record with id ${exactMatch.id}, updating it instead`);
              const duplicateUrl = `${this.api_url}/api/ratsit-data/${exactMatch.id}`;
              const dupResp = await axios.put(duplicateUrl, updateData, {
                headers: {
                  'Content-Type': 'application/json',
                  'Accept': 'application/json',
                  ...(this.api_token && { 'Authorization': `Bearer ${this.api_token}` }),
                },
                timeout: 30000,
                maxRedirects: 0,
                validateStatus: function (status) { return status >= 200 && status < 400; }
              });

              if (dupResp.status === 200) {
                console.log(`  ✅ Updated duplicate record ${exactMatch.id} successfully`);
                // Mark original queue entry as processed (avoid reattempts)
                try { await this.markRecordProcessed(recordId); } catch (e) { console.warn(`  ⚠️  Failed to mark original record ${recordId} processed:`, e?.message || e); }
                return true;
              }
            } else {
              console.log(`  🔍 Found ${matches.length} candidates for personnamn but no exact gatuadress match`);
            }
          }
        } catch (searchErr) {
          console.error(`  ❌ Error while resolving duplicate record:`, searchErr.response?.data || searchErr.message || searchErr);
        }
      }

      return false;
    }
  }

  /**
   * Mark a record as processed (set is_queued = false) without updating data
   * @param {number} recordId - The ID of the record to mark as processed
   * @returns {Promise<boolean>} Success status
   */
  async markRecordProcessed(recordId) {
    try {
      const apiUrl = `${this.api_url}/api/ratsit-data/${recordId}`;

      const response = await axios.put(apiUrl, { is_queued: false }, {
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          ...(this.api_token && { 'Authorization': `Bearer ${this.api_token}` })
        },
        timeout: 30000
      });

      return response.status === 200;
    } catch (error) {
      console.error(`  ❌ Error marking record ${recordId} as processed:`, error.response?.data || error.message);
      return false;
    }
  }

  closeDbConnection() {
    /** Close SQLite database connection */
    if (this.db) {
      this.db.close();
      this.db = null;
    }
  }

  async scrapeRatsitData(query) {
    /**
     * Scrape Ratsit data with complete extraction
     * Returns array of person data objects with full details
     */
    console.log(`  → Starting Ratsit scrape for: "${query}"`);

    const encodedQuery = encodeURIComponent(query);
    const searchUrl = `https://www.ratsit.se/sok/person?vem=${encodedQuery}`;

    let browser = null;
    const results = [];

    try {
      browser = await chromium.launch({
        headless: true,
        executablePath: '/usr/bin/google-chrome',
        args: [
          '--no-sandbox',
          '--disable-dev-shm-usage',
          '--disable-gpu',
          '--window-size=1920,1080',
          '--user-agent=Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        ]
      });

      const context = await browser.newContext();
      const page = await context.newPage();

      // Get search results
      await page.goto(searchUrl, { waitUntil: 'networkidle', timeout: 30000 });
      await page.waitForTimeout(2000);

      // Find all person links
      const links = [];
      const resultList = await page.$('ul.search-result-list');

      if (resultList) {
        const linkElements = await resultList.$$('li a[href^="https://www.ratsit.se/"]');
        for (const linkElement of linkElements) {
          const href = await linkElement.getAttribute('href');
          if (href && href.startsWith('https://www.ratsit.se/')) {
            links.push(href);
          }
        }
      }

      console.log(`  → Found ${links.length} Ratsit result(s)`);

      // Scrape each person page
      for (let i = 0; i < links.length; i++) {
        const link = links[i];
        console.log(`  → [${i + 1}/${links.length}] Scraping: ${link}`);

        try {
          await page.goto(link, { waitUntil: 'networkidle', timeout: 30000 });
          await page.waitForTimeout(1500);

          // Scroll to load lazy content
          await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
          await page.waitForTimeout(1000);

          // Extract person data
          const personData = {
            ps_personnummer: await this.extractRatsitTextAfterLabel(page, 'Personnummer:'),
            ps_alder: await this.extractRatsitTextAfterLabel(page, 'Ålder:'),
            ps_fodelsedag: await this.extractRatsitTextAfterLabel(page, 'Födelsedag:'),
            ps_kon: await this.extractRatsitTextAfterLabel(page, 'Juridiskt kön:'),
            ps_telefon: await this.extractRatsitTelefon(page),
            ps_personnamn: await this.extractRatsitTextAfterLabel(page, 'Personnamn:'),
            ps_fornamn: await this.extractRatsitTextAfterLabel(page, 'Förnamn:'),
            ps_efternamn: await this.extractRatsitTextAfterLabel(page, 'Efternamn:'),
            bo_gatuadress: await this.extractRatsitTextAfterLabel(page, 'Gatuadress:'),
            bo_postnummer: await this.extractRatsitTextAfterLabel(page, 'Postnummer:'),
            bo_postort: await this.extractRatsitTextAfterLabel(page, 'Postort:'),
            // Additional labels
            bo_forsamling: await this.extractRatsitTextAfterLabel(page, 'Församling:'),
            bo_kommun: await this.extractRatsitTextAfterLabel(page, 'Kommun:'),
            kommun_ratsit: await this.extractRatsitKommunLink(page),
            bo_lan: await this.extractRatsitTextAfterLabel(page, 'Län:'),
            ps_civilstand: await this.extractRatsitCivilstand(page),
            adressandring: await this.extractRatsitTextAfterLabel(page, 'Adressändring:'),
            stjarntacken: await this.extractRatsitTextAfterLabel(page, 'Stjärntecken:'),
            // Dwelling specific labels
            bo_agandeform: await this.extractRatsitTextAfterLabel(page, 'Ägandeform:'),
            bo_bostadstyp: await this.extractRatsitTextAfterLabel(page, 'Bostadstyp:'),
            bo_boarea: await this.extractRatsitTextAfterLabel(page, 'Boarea:'),
            bo_byggar: await this.extractRatsitTextAfterLabel(page, 'Byggår:'),
          };
          // Link for saving
          personData.ratsit_se = link;

          // Sections: telefonnummer (additional), personer, foretag, grannar, fordon, hundar, bolagsengagemang
          personData.telefonnummer = await this.extractSectionTelefonnummer(page);

          // DEBUG: Log extracted phone numbers
          if (personData.telefonnummer && personData.telefonnummer.length > 0) {
            console.log(`  🔍 DEBUG: Extracted ${personData.telefonnummer.length} phone numbers: ${personData.telefonnummer.join(', ')}`);
          } else {
            console.log(`  🔍 DEBUG: No phone numbers extracted from Telefonnummer section`);
          }

          const personer = await this.extractSectionListStrong(page, 'Personer');
          if (personer.length) personData.bo_personer = personer;
          const foretag = await this.extractSectionForetag(page);
          if (foretag.length) personData.bo_foretag = foretag;
          const grannar = await this.extractSectionGrannar(page);
          if (grannar.length) personData.bo_grannar = grannar;
          const fordon = await this.extractSectionFordon(page);
          if (fordon.length) personData.bo_fordon = fordon;
          const hundar = await this.extractSectionHundar(page);
          if (hundar.length) personData.bo_hundar = hundar;
          const bolag = await this.extractSectionBolagsengagemang(page);
          if (bolag.length) personData.ps_bolagsengagemang = bolag;

          // Lat/Long & Streetview
          const latLongText = await this.extractLatLongText(page);
          if (latLongText) {
            const m = latLongText.match(/Latitud:\s*([0-9.+-]+).*Longitud:\s*([0-9.+-]+)/i);
            if (m) {
              personData.latitud = m[1];
              personData.bo_longitude = m[2];
            }
          }
          personData.google_streetview = await this.extractStreetViewLink(page);

          // Google maps link - extract directly from "Navigera Till" button
          personData.google_maps = await this.extractGoogleMapsLink(page);

          // Fallback: if Google Maps link wasn't found, generate it from address
          if (!personData.google_maps && personData.bo_gatuadress && personData.bo_postnummer && personData.bo_postort) {
            const addr = `${personData.bo_gatuadress}, ${personData.bo_postnummer} ${personData.bo_postort}`;
            personData.google_maps = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(addr)}`;
          }

          // Map gender value
          if (personData.ps_kon) {
            const konMap = { 'man': 'M', 'kvinna': 'F', 'kvinno': 'F' };
            const lowerKon = personData.ps_kon.toLowerCase().trim();
            personData.ps_kon = konMap[lowerKon] || personData.ps_kon;
          }

          // Handle telefon as string (single number) and telefonnummer as array
          // NOTE: We do NOT filter out ps_telefon from telefonnummer array anymore
          // The telefonnummer array should contain ALL phone numbers from the "Telefonnummer" section
          // ps_telefon is extracted separately from the "Telefon:" label
          if (!personData.ps_telefon && personData.telefonnummer && Array.isArray(personData.telefonnummer) && personData.telefonnummer.length > 0) {
            // Only if we don't have a primary telefon, use first from array
            personData.ps_telefon = personData.telefonnummer[0];
          }

          const cleanData = {};
          for (const [key, value] of Object.entries(personData)) {
            if (value === null || value === undefined) continue;
            if (Array.isArray(value) && value.length === 0) continue;
            if (typeof value === 'string' && value.trim() === '') continue;

            // Filter out unwanted text patterns
            let cleanedValue = value;
            if (typeof value === 'string') {
              cleanedValue = this.filterUnwantedText(value);
              if (cleanedValue === '') continue; // Skip if only contained unwanted text
            } else if (Array.isArray(value)) {
              cleanedValue = value
                .map(item => {
                  if (typeof item === 'string') {
                    return this.filterUnwantedText(item);
                  } else if (item && typeof item === 'object' && item.text) {
                    // Handle objects with text property (like {text: '...', link: '...'})
                    return {
                      ...item,
                      text: this.filterUnwantedText(item.text)
                    };
                  }
                  return item;
                })
                .filter(item => {
                  if (typeof item === 'string') return item !== '';
                  if (item && typeof item === 'object' && item.text) return item.text !== '';
                  return item !== null && item !== undefined;
                });
              if (cleanedValue.length === 0) continue;
            }

            cleanData[key] = cleanedValue;
          }

          if (Object.keys(cleanData).length > 0) {
            results.push(cleanData);
            console.log(`  → ✓ Extracted data for ${cleanData.ps_personnamn || 'Unknown'}`);

            // Log extracted data details
            console.log('\n  📋 Scraped Data Summary:');
            console.log(`     Person: ${cleanData.ps_personnummer || 'N/A'} | ${cleanData.ps_personnamn || 'N/A'} | Age: ${cleanData.ps_alder || 'N/A'}`);
            console.log(`     Address: ${cleanData.bo_gatuadress || 'N/A'}, ${cleanData.bo_postnummer || 'N/A'} ${cleanData.bo_postort || 'N/A'}`);
            console.log(`     Location: ${cleanData.bo_forsamling || 'N/A'} / ${cleanData.bo_kommun || 'N/A'} / ${cleanData.bo_lan || 'N/A'}`);
            console.log(`     Phone: ${cleanData.ps_telefon || 'N/A'}`);
            console.log(`     Additional Phones: ${Array.isArray(cleanData.telefonnummer) ? cleanData.telefonnummer.join(', ') : 'N/A'}`);
            console.log(`     Dwelling: ${cleanData.bo_bostadstyp || 'N/A'} | ${cleanData.bo_agandeform || 'N/A'} | ${cleanData.bo_boarea || 'N/A'}m² | Built: ${cleanData.bo_byggar || 'N/A'}`);
            console.log(`     Civil: ${cleanData.ps_civilstand || 'N/A'} | Sign: ${cleanData.stjarntacken || 'N/A'}`);
            console.log(`     Collections: Personer(${cleanData.bo_personer?.length || 0}) Företag(${cleanData.bo_foretag?.length || 0}) Grannar(${cleanData.bo_grannar?.length || 0})`);
            console.log(`                  Fordon(${cleanData.bo_fordon?.length || 0}) Hundar(${cleanData.bo_hundar?.length || 0}) Bolag(${cleanData.ps_bolagsengagemang?.length || 0})`);
            console.log(`     Geo: Lat ${cleanData.latitud || 'N/A'}, Long ${cleanData.bo_longitude || 'N/A'}`);
            console.log(`     Links: ${cleanData.ratsit_se ? '✓ Ratsit' : '✗'} ${cleanData.google_maps ? '✓ Maps' : '✗'} ${cleanData.google_streetview ? '✓ Street' : '✗'}\n`);
          }

          await page.waitForTimeout(500);

        } catch (error) {
          console.log(`  → ✗ Error scraping ${link}:`, error.message);
        }
      }

      await browser.close();

    } catch (error) {
      console.log(`  → ✗ Error during Ratsit scraping:`, error.message);
      if (browser) {
        await browser.close();
      }
    }

    return results;
  }

  async extractRatsitTextAfterLabel(page, labelText) {
    /** Extract text value after a label span on Ratsit pages */
    try {
      const labelSelector = `span.color--gray5:has-text("${labelText}")`;
      const labelElement = await page.$(labelSelector);

      if (!labelElement) {
        return null;
      }

      const result = await labelElement.evaluate((el, label) => {
        const p = el.closest('p');
        if (!p) return null;

        // Check if there's an anchor tag inside the paragraph (for fields like Stjärntecken)
        const link = p.querySelector('a');
        if (link) {
          // Extract just the text from the anchor, not the full URL
          return link.textContent?.trim() || null;
        }

        // Otherwise, get the inner text
        return p.innerText;
      }, labelText);

      if (!result) {
        return null;
      }

      let text = result.replace(labelText, '').trim();
      text = text.replace(/\s*Visas för medlemmar.*/gi, '');

      return text || null;
    } catch (e) {
      return null;
    }
  }

  async extractRatsitTelefon(page) {
    /** Extract telefon number from href tel: link on Ratsit pages */
    try {
      const labelSelector = 'span.color--gray5:has-text("Telefon:")';
      const labelElement = await page.$(labelSelector);

      if (!labelElement) {
        return null;
      }

      const telHref = await labelElement.evaluate((el) => {
        const p = el.closest('p');
        if (!p) return null;
        const telLink = p.querySelector('a[href^="tel:"]');
        return telLink ? telLink.getAttribute('href') : null;
      });

      if (telHref && telHref.startsWith('tel:')) {
        return telHref.replace('tel:', '');
      }

      return null;
    } catch (e) {
      return null;
    }
  }

  async extractRatsitCivilstand(page) {
    // Look for a section where heading contains Civilstånd and return the content after the heading
    try {
      const heading = await page.$('h2:has-text("Civilstånd")');
      if (heading) {
        const parent = await heading.evaluateHandle((el) => el.parentElement);
        if (parent) {
          const fullText = await parent.evaluate((el) => {
            // Get all text content including links
            return el.textContent?.trim() || null;
          });
          if (fullText && !this.containsUnwantedText(fullText)) {
            // Remove the heading "Civilstånd" from the beginning
            const cleaned = fullText.replace(/^Civilstånd\s*/, '').trim();
            return this.filterUnwantedText(cleaned);
          }
        }
      }
      return null;
    } catch { return null; }
  }

  async extractRatsitKommunLink(page) {
    // Extract the kommun link from the kommun field
    try {
      const labelSelector = 'span.color--gray5:has-text("Kommun:")';
      const labelElement = await page.$(labelSelector);

      if (!labelElement) {
        return null;
      }

      const kommunLink = await labelElement.evaluate((el) => {
        const p = el.closest('p');
        if (!p) return null;
        const link = p.querySelector('a[href]');
        return link ? link.getAttribute('href') : null;
      });

      if (kommunLink) {
        // Convert relative URL to absolute URL
        if (kommunLink.startsWith('/')) {
          return 'https://www.ratsit.se' + kommunLink;
        }
        return kommunLink;
      }

      return null;
    } catch (e) {
      return null;
    }
  }

  async extractSectionTelefonnummer(page) {
    try {
      // Try robust extraction by scanning H3/H4 headers with text containing "Telefon"
      const numbers = await page.evaluate(() => {
        const out = [];

        function collectFromNode(node) {
          if (!node) return;
          // If node is hidden (d-none) skip
          if (node.classList && node.classList.contains('d-none')) return;
          // Collect spans inside p.row (visible)
          if (node.matches && node.matches('p.row')) {
            node.querySelectorAll('span.text-nowrap').forEach(span => {
              const txt = (span.textContent || '').trim();
              if (txt) out.push(txt);
            });
            return;
          }
          // If the node contains p.row children, collect them
          const ps = node.querySelectorAll && node.querySelectorAll('p.row');
          if (ps && ps.length) {
            ps.forEach(p => {
              if (p.classList && p.classList.contains('d-none')) return;
              p.querySelectorAll('span.text-nowrap').forEach(span => {
                const txt = (span.textContent || '').trim();
                if (txt) out.push(txt);
              });
            });
          }
        }

        const headers = Array.from(document.querySelectorAll('h3, h4'));
        for (const h of headers) {
          if (!h.textContent) continue;
          if (/telefon/i.test(h.textContent)) {
            // Walk siblings until next header
            let node = h.nextElementSibling;
            while (node && !['H3','H4'].includes(node.tagName)) {
              collectFromNode(node);
              node = node.nextElementSibling;
            }
            if (out.length) return Array.from(new Set(out));
          }
        }

        // Fallback: gather any visible p.row spans on the page
        const fallback = [];
        document.querySelectorAll('p.row').forEach(p => {
          if (p.classList && p.classList.contains('d-none')) return;
          p.querySelectorAll('span.text-nowrap').forEach(span => {
            const txt = (span.textContent || '').trim();
            if (txt) fallback.push(txt);
          });
        });
        return Array.from(new Set(fallback));
      });

      // Normalize and filter extracted values using a permissive phone regex
      const cleaned = Array.isArray(numbers)
        ? numbers
            .map(s => (s || '').replace(/\s+/g, ' ').trim())
            .filter(s => /(^0\d{2,3}[\- \d]{6,}|^(\+|00)46[\- \d]{7,}|^0\d{6,})/.test(s))
        : [];

      return this.filterExtractionResults(cleaned);
    } catch (err) {
      console.error('extractSectionTelefonnummer error:', err.message);
      return [];
    }
  }

  async extractSectionListStrong(page, headerText) {
    try {
      const header = await page.$(`h3:has-text("${headerText}")`);
      if (!header) return [];
      const container = await header.evaluateHandle((el) => el.parentElement?.parentElement);
      const items = await page.evaluate((root) => {
        if (!root) return [];
        const arr = [];
        root.querySelectorAll('strong').forEach((el) => {
          const text = el.textContent?.trim();
          if (text) {
            // Look for a link within or as a parent of this strong element
            let link = null;
            let linkElement = el.querySelector('a[href]');
            if (!linkElement) {
              // Check if the strong element itself is inside a link
              linkElement = el.closest('a[href]');
            }
            if (linkElement) {
              link = linkElement.getAttribute('href');
              // Convert relative URLs to absolute
              if (link && link.startsWith('/')) {
                link = 'https://www.ratsit.se' + link;
              }
            }
            arr.push({ text, link });
          }
        });
        return arr;
      }, container);
      return this.filterExtractionResults(items);
    } catch { return []; }
  }

  async extractSectionForetag(page) {
    try {
      const header = await page.$('h3:has-text("Företag")');
      if (!header) return [];
      const container = await header.evaluateHandle((el) => el.parentElement?.querySelector('table'));
      const rows = await page.evaluate((tbl) => {
        const out = [];
        if (!tbl) return out;
        tbl.querySelectorAll('tbody tr').forEach((tr) => {
          const cells = Array.from(tr.querySelectorAll('td'));
          if (cells.length) {
            // Look for links in the cells
            let text = cells.map((td) => td.innerText.trim()).join(' | ');
            let link = null;

            // Check for links in any cell
            for (const cell of cells) {
              const linkElement = cell.querySelector('a[href]');
              if (linkElement) {
                link = linkElement.getAttribute('href');
                // Convert relative URLs to absolute
                if (link && link.startsWith('/')) {
                  link = 'https://www.ratsit.se' + link;
                }
                break; // Use the first link found
              }
            }

            out.push({ text, link });
          }
        });
        return out;
      }, container);
      return this.filterExtractionResults(rows);
    } catch { return []; }
  }

  async extractSectionGrannar(page) {
    try {
      const titles = await page.$$('button.accordion-neighbours__title');
      const out = [];
      for (const btn of titles) {
        // Expand if possible (best effort)
        try { await btn.click({ timeout: 500 }); } catch {}
      }
      const rows = await page.$$('div .accordion-neighbours__title ~ div table tbody tr');
      for (const tr of rows) {
        const result = await tr.evaluate((el) => {
          const text = el.innerText.replace(/\s+/g, ' ').trim();
          let link = null;
          const linkElement = el.querySelector('a[href]');
          if (linkElement) {
            link = linkElement.getAttribute('href');
            // Convert relative URLs to absolute
            if (link && link.startsWith('/')) {
              link = 'https://www.ratsit.se' + link;
            }
          }
          return { text, link };
        });
        if (result.text) out.push(result);
      }
      return this.filterExtractionResults(out);
    } catch { return []; }
  }

  async extractSectionFordon(page) {
    try {
      const header = await page.$('h3:has-text("Fordon")');
      if (!header) return [];
      const table = await header.evaluateHandle((el) => el.parentElement?.querySelector('table'));
      const rows = await page.evaluate((tbl) => {
        const out = [];
        if (!tbl) return out;
        tbl.querySelectorAll('tbody tr').forEach((tr) => {
          const tds = tr.querySelectorAll('td');
          if (tds.length) {
            const brand = tds[0]?.innerText.trim();
            const model = tds[1]?.innerText.trim();
            const year = tds[2]?.innerText.trim();
            const color = tds[3]?.innerText.trim();
            const owner = tds[4]?.innerText.trim();
            const text = [brand, model, year, color, owner].filter(Boolean).join(', ');

            // Look for links in any cell
            let link = null;
            for (const td of tds) {
              const linkElement = td.querySelector('a[href]');
              if (linkElement) {
                link = linkElement.getAttribute('href');
                // Convert relative URLs to absolute
                if (link && link.startsWith('/')) {
                  link = 'https://www.ratsit.se' + link;
                }
                break; // Use the first link found
              }
            }

            out.push({ text, link });
          }
        });
        return out;
      }, table);
      return this.filterExtractionResults(rows);
    } catch { return []; }
  }

  async extractSectionHundar(page) {
    try {
      const header = await page.$('h3:has-text("Hundar")');
      if (!header) return [];
      const container = await header.evaluateHandle((el) => el.parentElement);

      // Strategy 1: Prefer structured table parsing if present
      const table = await header.evaluateHandle((el) => el.parentElement?.querySelector('table'));
      const tableRows = await page.evaluate((tbl) => {
        const out = [];
        if (!tbl) return out;
        let rows = tbl.querySelectorAll('tbody tr');
        if (!rows.length) rows = tbl.querySelectorAll('tr');
        rows.forEach((tr) => {
          const cells = Array.from(tr.querySelectorAll('td, th')).map((c) => c.innerText.replace(/\s+/g, ' ').trim());
          if (!cells.length) return;
          // Skip header rows
          const headerLike = cells.join(' ').match(/^(Ras|Hund|Födelsedatum|Ålder|Ägare|Namn)/i);
          if (headerLike) return;
          const text = cells.filter(Boolean).join(', ');

          // Look for links in any cell
          let link = null;
          const linkElements = tr.querySelectorAll('a[href]');
          if (linkElements.length) {
            link = linkElements[0].getAttribute('href');
            // Convert relative URLs to absolute
            if (link && link.startsWith('/')) {
              link = 'https://www.ratsit.se' + link;
            }
          }

          if (text) out.push({ text, link });
        });
        return out;
      }, table);
      if (Array.isArray(tableRows) && tableRows.length) return this.filterExtractionResults(tableRows);

      // Strategy 2: Fallback to heuristic grouping of lines (breed, date (age), owner)
      const lines = await page.evaluate((root) => {
        const out = [];
        if (!root) return out;
        const rawLines = (root.innerText || '')
          .split('\n')
          .map((l) => l.trim())
          .filter(Boolean)
          .filter((l) => {
            // Filter out unwanted text patterns
            return !/^Hundar$/i.test(l) &&
                   !/Visa mer|Visa mindre/i.test(l) &&
                   !/DOLT - Bli validerad medlem för att se/i.test(l) &&
                   !/Kolla lön direkt/i.test(l);
          });

        const isDateAge = (s) => /\d{4}-\d{2}-\d{2}/.test(s) || /\(\d+\s*år\)/i.test(s);
        for (let i = 0; i < rawLines.length; i++) {
          if (!isDateAge(rawLines[i])) continue;
          const dateAge = rawLines[i];
          const breed = rawLines[i - 1] && !isDateAge(rawLines[i - 1]) ? rawLines[i - 1] : null;
          const owner = rawLines[i + 1] && !isDateAge(rawLines[i + 1]) ? rawLines[i + 1] : null;
          const text = [breed, dateAge, owner].filter(Boolean).join(', ');

          // For fallback strategy, we don't have easy access to links, so link will be null
          if (text) out.push({ text, link: null });
        }
        // Deduplicate while preserving order
        return Array.from(new Set(out.map(item => JSON.stringify(item)))).map(item => JSON.parse(item));
      }, container);
      return this.filterExtractionResults(lines);
    } catch { return []; }
  }

  async extractSectionBolagsengagemang(page) {
    try {
      // Check if "Bolagsengagemang" text exists anywhere on page
      const hasText = await page.locator('text="Bolagsengagemang"').count();
      if (!hasText) {
        return [];
      }

      // Since heading might be in sidebar or other location, search page-wide for any section/div with id="engagemang"
      const sectionEl = await page.$('[id="engagemang"]');
      if (sectionEl) {
        const items = await sectionEl.evaluate((sec) => {
          const out = [];
          const tbl = sec.querySelector('table');
          if (!tbl) return out;
          let rows = tbl.querySelectorAll('tbody tr');
          if (!rows.length) rows = tbl.querySelectorAll('tr');
          rows.forEach((tr) => {
            const cells = Array.from(tr.querySelectorAll('td, th')).map(c => c.innerText.replace(/\s+/g,' ').trim());
            if (cells.length && !cells[0].match(/^(Företagsnamn|Typ|Status|Befattning)/i)) {
              const text = cells.join(', ');

              // Look for links in any cell
              let link = null;
              const linkElements = tr.querySelectorAll('a[href]');
              if (linkElements.length) {
                link = linkElements[0].getAttribute('href');
                // Convert relative URLs to absolute
                if (link && link.startsWith('/')) {
                  link = 'https://www.ratsit.se' + link;
                }
              }

              out.push({ text, link });
            }
          });
          return out;
        });
        if (items.length > 0) {
          return this.filterExtractionResults(items);
        }
      }

      // Fallback: find any h2 containing "Bolagsengagemang" in main content (not sidebar)
      const mainHeader = await page.$('main h2:has-text("Bolagsengagemang"), article h2:has-text("Bolagsengagemang")');
      if (mainHeader) {
        await mainHeader.scrollIntoViewIfNeeded();
        await page.waitForTimeout(1000);
        const items = await mainHeader.evaluate((h) => {
          const out = [];
          // Search next siblings or parent container
          let node = h.nextElementSibling;
          while (node && !node.matches('h1,h2,h3')) {
            const tbl = node.matches('table') ? node : node.querySelector('table');
            if (tbl) {
              let rows = tbl.querySelectorAll('tbody tr');
              if (!rows.length) rows = tbl.querySelectorAll('tr');
              rows.forEach((tr) => {
                const cells = Array.from(tr.querySelectorAll('td, th')).map(c => c.innerText.replace(/\s+/g,' ').trim());
                if (cells.length && !cells[0].match(/^(Företagsnamn|Typ|Status|Befattning)/i)) {
                  const text = cells.join(', ');

                  // Look for links in any cell
                  let link = null;
                  const linkElements = tr.querySelectorAll('a[href]');
                  if (linkElements.length) {
                    link = linkElements[0].getAttribute('href');
                    // Convert relative URLs to absolute
                    if (link && link.startsWith('/')) {
                      link = 'https://www.ratsit.se' + link;
                    }
                  }

                  out.push({ text, link });
                }
              });
              return out;
            }
            node = node.nextElementSibling;
          }
          return out;
        });
        if (items.length > 0) {
          return this.filterExtractionResults(items);
        }
      }

      return [];
    } catch (e) {
      return [];
    }
  }

  async extractLatLongText(page) {
    try {
      const el = await page.$('div:has-text("Latitud:")');
      if (!el) return null;
      return await el.innerText();
    } catch { return null; }
  }

  async extractGoogleMapsLink(page) {
    try {
      // Look for the "Navigera Till Adressen" button with Google Maps link
      const linkEl = await page.$('a[href*="maps.google.com"][data-ga-event-label*="Navigera"]');
      if (!linkEl) return null;
      return await linkEl.getAttribute('href');
    } catch { return null; }
  }

  async extractStreetViewLink(page) {
    try {
      const linkEl = await page.$('a[href*="map_action=pano"][href*="viewpoint="]');
      if (!linkEl) return null;
      return await linkEl.getAttribute('href');
    } catch { return null; }
  }
}

// Main function
async function main() {
  program
    .description('Process queued ratsit_data records: fetch from database, scrape Ratsit.se, update records, and mark as processed')
    .argument('[postnummer]', 'Optional postnummer to filter queued records (e.g., "15332" or "153 32")')
    .option('--api-url <url>', 'Laravel API URL (default: http://localhost:8000)')
    .option('--api-token <token>', 'API authentication token')
    .option('--limit <number>', 'Maximum number of queued records to process (default: 1000)')
    .parse();

  const options = program.opts();
  const postnummer = program.args[0] || null; // Keep postnummer as-is (with spaces if present)
  const limit = parseInt(options.limit) || 100000;

  const scraper = new RatsitScraper(options.apiUrl, options.apiToken);

  try {
    // Fetch queued records from database (optionally filtered by postnummer)
    const queuedRecords = await scraper.fetchQueuedRecords(limit, postnummer);

    if (!queuedRecords || queuedRecords.length === 0) {
      const filterMsg = postnummer ? ` for postnummer ${postnummer}` : '';
      console.log(`No queued ratsit_data records found${filterMsg}`);
      return;
    }

    const filterMsg = postnummer ? ` (filtered by postnummer: ${postnummer})` : '';
    console.log(`\n→ Found ${queuedRecords.length} queued ratsit_data record(s) to process${filterMsg}...`);

    let processed = 0;
    let updated = 0;

    for (const record of queuedRecords) {
      console.log(`\n[${processed + 1}/${queuedRecords.length}] Processing: ${record.person?.personnamn || 'undefined'} (ID: ${record.id})`);

      try {
        // Build search query using both personnamn and gatuadress for better accuracy
        const personnamn = record.person?.personnamn;
        const gatuadress = record.address?.gatuadress;

        let searchQuery = personnamn || '';

        // Add address to search query if available
        if (gatuadress && gatuadress.trim() !== '') {
          searchQuery = `${personnamn}, ${gatuadress}`.trim();
        }

        if (!searchQuery || searchQuery.trim() === '') {
          console.log(`   ⏭️  Skipping record ${record.id} - no personnamn or address`);
          continue;
        }

        console.log(`   🔍 Searching Ratsit for: "${searchQuery}"`);

        // Scrape Ratsit data
        const ratsitResults = await scraper.scrapeRatsitData(searchQuery);

        if (!ratsitResults || ratsitResults.length === 0) {
          console.log(`   ⏭️  No Ratsit results found for "${searchQuery}"`);
          // Still mark as processed to avoid infinite retries
          await scraper.markRecordProcessed(record.id);
          processed++;
          continue;
        }

        console.log(`   📊 Found ${ratsitResults.length} Ratsit result(s)`);

        // Find the best matching result (first one for now)
        const bestResult = ratsitResults[0];

        // Update the record with Ratsit data and mark as processed
        const success = await scraper.updateRecordWithRatsitData(record.id, bestResult);

        if (success) {
          console.log(`   ✅ Updated record ${record.id} with Ratsit data`);
          updated++;
        } else {
          console.log(`   ❌ Failed to update record ${record.id}`);
        }

        processed++;

        // Small delay between requests to be respectful
        await new Promise(resolve => setTimeout(resolve, 2000));

      } catch (error) {
        console.log(`   ❌ Error processing record ${record.id}: ${error.message}`);
        processed++;
        // Continue with next record
      }
    }

    console.log(`\n✓ Processed ${processed}/${queuedRecords.length} queued record(s), updated ${updated} with Ratsit data`);

  } finally {
    // Always close database connection
    scraper.closeDbConnection();
  }
}

// Run main function
main().catch(error => {
  console.error('Error:', error);
  process.exit(1);
});
