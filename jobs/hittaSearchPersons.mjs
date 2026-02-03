#!/usr/bin/env node

/**
 * Hitta.se Person Search & Database Importer
 *
 * This script scrapes person data from Hitta.se and saves it to the database
 * after each page is completed. This ensures data persistence even if the
 * script is interrupted.
 *
 * Saves to: hitta_se, personer_data, hitta_data, and ratsit_data tables
 * Ratsit data is only saved for records with is_hus = true and is_telefon = true,
 * and is marked with is_queued = true for further processing
 *
 * Features:
 * - Page-by-page database persistence via batch API
 * - CSV export for backup
 * - Optional Ratsit integration with --ratsit flag
 * - Robust error handling and retry logic
 *
 * Usage:
 *   node hittaSearchPersons.mjs "postal code"
 *   node hittaSearchPersons.mjs "153 32" --ratsit
 *
 * Requirements:
 * - Laravel API server must be running (php artisan serve)
 * - Batch API endpoints: /api/hitta-se/batch, /api/personer-data/bulk, /api/hitta-data/bulk, /api/ratsit-data/bulk
 */

import { Command } from "commander";
import axios from "axios";
import { JSDOM } from "jsdom";
import fs from "fs";
import path from "path";
import { execSync } from "child_process";

// --- API Configuration ---
const API_BASE = process.env.API_BASE || process.env.APP_URL || "http://127.0.0.1:8000";
const BATCH_ENDPOINT = `${API_BASE.replace(/\/$/, "")}/api/hitta-se/batch`;
const PERSONER_DATA_BATCH_ENDPOINT = `${API_BASE.replace(/\/$/, "")}/api/personer-data/bulk`;
const HITTA_DATA_BATCH_ENDPOINT = `${API_BASE.replace(/\/$/, "")}/api/hitta-data/bulk`;
const RATSIT_DATA_BATCH_ENDPOINT = `${API_BASE.replace(/\/$/, "")}/api/ratsit-data/bulk`;

// SQLite functionality disabled for efficiency
// All data goes directly to Filament database via API

function saveToSQLite(persons) {
  // SQLite saving disabled for efficiency
  return { hittaCreated: 0, hittaUpdated: 0, personerUpserted: 0, hittaIds: [] };
}

// --- Helper Functions ---

function mapPersonToApiPayload(person) {
  const payload = {
    personnamn: person.personnamn || null,
    alder: person.alder || null,
    kon: person.kon || null,
    gatuadress: person.gatuadress || null,
    postnummer: person.postnummer || null,
    postort: person.postort || null,
    karta: person.karta || null,
    link: person.link || null,
    bostadstyp: null,
    bostadspris: null,
    is_active: true,
    is_telefon: false,
    is_ratsit: false,
    is_hus: true, // Default to true (house), will be set to false if matches apartment pattern
  };

  // Check if address indicates apartment (not a house)
  const isHusFalsePattern = /lgh|1 tr|2 tr|3 tr|4 tr|5 tr|6 tr| nb| box| nb| bv|\bBox\b|\b([1-9][0-9]?|100)\s*[A-Z]\b/i;
  if (person.gatuadress && isHusFalsePattern.test(person.gatuadress)) {
    payload.is_hus = false;
  }

  if (person.telefon && person.telefon !== "Lägg till telefonnummer") {
    const clean = String(person.telefon).trim();
    if (clean) {
      payload.telefon = [clean];
      payload.is_telefon = true;
    } else {
      payload.telefon = [];
    }
  } else {
    payload.telefon = [];
  }

  return payload;
}

async function savePersonsViaApi(persons) {
  if (!persons || persons.length === 0) {
    console.log("⏭️  No persons to save");
    return { created: 0, updated: 0, failed: 0 };
  }

  console.log(`💾 Saving ${persons.length} persons to Filament database via API...`);

  // Process in larger batches for efficiency (100 instead of 50)
  const batchSize = 100;
  let totalCreated = 0;
  let totalUpdated = 0;
  let totalFailed = 0;
  let hittaDataCreated = 0;
  let hittaDataUpdated = 0;
  let hittaDataFailed = 0;
  let ratsitDataCreated = 0;
  let ratsitDataUpdated = 0;
  let ratsitDataFailed = 0;

  for (let i = 0; i < persons.length; i += batchSize) {
    const batch = persons.slice(i, i + batchSize);
    const batchNum = Math.floor(i / batchSize) + 1;
    const totalBatches = Math.ceil(persons.length / batchSize);

    const payload = {
      records: batch.map((p) => mapPersonToApiPayload(p)),
    };

    try {
      console.log(`📤 Batch ${batchNum}/${totalBatches} (${batch.length} records)...`);

      // Save to hitta_se table
      const res = await axios.post(BATCH_ENDPOINT, payload, {
        headers: { "Content-Type": "application/json" },
        timeout: 45000, // Increased timeout for larger batches
      });

      if (res.status === 200 && res.data) {
        totalCreated += res.data.hitta_se?.created || res.data.created || 0;
        totalUpdated += res.data.hitta_se?.updated || res.data.updated || 0;
        totalFailed += res.data.hitta_se?.failed || res.data.failed || 0;
        console.log(
          `   ✅ hitta_se: Created: ${res.data.hitta_se?.created || res.data.created || 0}, Updated: ${res.data.hitta_se?.updated || res.data.updated || 0}, Failed: ${res.data.hitta_se?.failed || res.data.failed || 0}`,
        );
      } else {
        totalFailed += batch.length;
        console.log(`   ❌ hitta_se: Unexpected status ${res.status}`);
      }

      // Save to hitta_data table
      try {
        const hittaDataPayload = {
          records: batch.map((p) => {
            const personPayload = mapPersonToApiPayload(p);
            // Map telefon array to both telefon (string) and telefonnumer (array)
            if (personPayload.telefon && Array.isArray(personPayload.telefon) && personPayload.telefon.length > 0) {
              personPayload.telefonnumer = personPayload.telefon;
              personPayload.telefon = personPayload.telefon.join(', ');
            } else {
              personPayload.telefonnumer = [];
              personPayload.telefon = null;
            }
            return personPayload;
          }),
        };

        const hittaDataRes = await axios.post(HITTA_DATA_BATCH_ENDPOINT, hittaDataPayload, {
          headers: { "Content-Type": "application/json" },
          timeout: 45000,
        });

        if (hittaDataRes.status === 200 && hittaDataRes.data) {
          hittaDataCreated += hittaDataRes.data.summary?.created || 0;
          hittaDataUpdated += hittaDataRes.data.summary?.updated || 0;
          hittaDataFailed += hittaDataRes.data.summary?.failed || 0;
          console.log(
            `   ✅ hitta_data: Created: ${hittaDataRes.data.summary?.created || 0}, Updated: ${hittaDataRes.data.summary?.updated || 0}, Failed: ${hittaDataRes.data.summary?.failed || 0}`,
          );
        } else {
          hittaDataFailed += batch.length;
          console.log(`   ❌ hitta_data: Unexpected status ${hittaDataRes.status}`);
        }
      } catch (hittaDataErr) {
        hittaDataFailed += batch.length;
        console.log(`   ❌ hitta_data batch failed: ${hittaDataErr.message}`);
      }

      // Save to ratsit_data table (only for records with is_hus = true and is_telefon = true)
      try {
        const filteredBatch = batch.filter((p) => {
          const personPayload = mapPersonToApiPayload(p);
          return personPayload.is_hus === true && personPayload.is_telefon === true;
        });

        if (filteredBatch.length === 0) {
          console.log(`   ⏭️  No eligible records for ratsit_data (need is_hus=true and is_telefon=true)`);
        } else {
          const ratsitDataPayload = {
            records: filteredBatch.map((p) => {
              const personPayload = mapPersonToApiPayload(p);
              return {
                personnamn: personPayload.personnamn,
                fornamn: null,
                efternamn: null,
                gatuadress: personPayload.gatuadress,
                postnummer: personPayload.postnummer,
                postort: personPayload.postort,
                alder: personPayload.alder,
                kon: personPayload.kon,
                telefon: personPayload.telefon && Array.isArray(personPayload.telefon) && personPayload.telefon.length > 0
                  ? personPayload.telefon[0]
                  : null,
                telfonnummer: personPayload.telefon && Array.isArray(personPayload.telefon) && personPayload.telefon.length > 0
                  ? personPayload.telefon.join('|')
                  : null,
                is_active: true,
                is_queued: true,
              };
            }),
          };

          const ratsitDataRes = await axios.post(RATSIT_DATA_BATCH_ENDPOINT, ratsitDataPayload, {
            headers: { "Content-Type": "application/json" },
            timeout: 45000,
          });

          if (ratsitDataRes.status === 200 && ratsitDataRes.data) {
            ratsitDataCreated += ratsitDataRes.data.summary?.created || 0;
            ratsitDataUpdated += ratsitDataRes.data.summary?.updated || 0;
            ratsitDataFailed += ratsitDataRes.data.summary?.failed || 0;
            console.log(
              `   ✅ ratsit_data: Created: ${ratsitDataRes.data.summary?.created || 0}, Updated: ${ratsitDataRes.data.summary?.updated || 0}, Failed: ${ratsitDataRes.data.summary?.failed || 0} (${filteredBatch.length} eligible records)`,
            );
          } else {
            ratsitDataFailed += filteredBatch.length;
            console.log(`   ❌ ratsit_data: Unexpected status ${ratsitDataRes.status}`);
          }
        }
      } catch (ratsitDataErr) {
        const filteredBatch = batch.filter((p) => {
          const personPayload = mapPersonToApiPayload(p);
          return personPayload.is_hus === true && personPayload.is_telefon === true;
        });
        ratsitDataFailed += filteredBatch.length;
        console.log(`   ❌ ratsit_data batch failed: ${ratsitDataErr.message}`);
      }
    } catch (err) {
      totalFailed += batch.length;
      hittaDataFailed += batch.length;
      ratsitDataFailed += batch.length;
      console.log(`   ❌ hitta_se batch ${batchNum} failed: ${err.message}`);

      if (err.code === 'ECONNREFUSED' || err.code === 'ETIMEDOUT') {
        console.log(`   ⚠️  Connection error. Make sure Laravel server is running (php artisan serve)`);
      }
    }

    // Reduced delay between batches for efficiency
    if (i + batchSize < persons.length) {
      await new Promise((r) => setTimeout(r, 200));
    }
  }

  const hittaSummary = `hitta_se - Created: ${totalCreated}, Updated: ${totalUpdated}, Failed: ${totalFailed}`;
  const hittaDataSummary = `hitta_data - Created: ${hittaDataCreated}, Updated: ${hittaDataUpdated}, Failed: ${hittaDataFailed}`;
  const ratsitDataSummary = `ratsit_data - Created: ${ratsitDataCreated}, Updated: ${ratsitDataUpdated}, Failed: ${ratsitDataFailed}`;

  if (totalFailed > 0 || hittaDataFailed > 0 || ratsitDataFailed > 0) {
    console.log(`⚠️  Database save completed with errors.`);
    console.log(`   ${hittaSummary}`);
    console.log(`   ${hittaDataSummary}`);
    console.log(`   ${ratsitDataSummary}`);
  } else {
    console.log(`✅ Filament database save complete.`);
    console.log(`   ${hittaSummary}`);
    console.log(`   ${hittaDataSummary}`);
    console.log(`   ${ratsitDataSummary}`);
  }

  return {
    created: totalCreated,
    updated: totalUpdated,
    failed: totalFailed,
    hittaDataCreated,
    hittaDataUpdated,
    hittaDataFailed,
    ratsitDataCreated,
    ratsitDataUpdated,
    ratsitDataFailed
  };
}

async function runRatsitForPersons(persons) {
  const personsWithPhone = persons.filter(
    (p) => p.telefon && p.telefon !== "Lägg till telefonnummer",
  );

  if (personsWithPhone.length === 0) {
    console.log("⏭️  No persons with phone numbers to process with Ratsit");
    return;
  }

  console.log(`\n🔍 Running Ratsit for ${personsWithPhone.length} persons with phone numbers...`);

  let processedCount = 0;
  let successCount = 0;

  for (const person of personsWithPhone) {
    processedCount++;
    console.log(`\n[${processedCount}/${personsWithPhone.length}] Processing: ${person.personnamn} (${person.telefon})`);

    try {
      // Use person name as search query for Ratsit
      const searchQuery = person.personnamn;

      // Build command to run ratsit.mjs script
      const ratsitCommand = `node ratsit.mjs "${searchQuery}" --api-url "${process.env.LARAVEL_API_URL || process.env.APP_URL}" --api-token "${process.env.LARAVEL_API_TOKEN || ''}"`;

      console.log(`   → Running: ${ratsitCommand}`);

      // Execute ratsit script
      const output = execSync(ratsitCommand, {
        cwd: path.dirname(new URL(import.meta.url).pathname),
        encoding: 'utf8',
        timeout: 60000, // 60 second timeout per person
        stdio: 'pipe'
      });

      console.log(`   ✓ Ratsit completed for ${person.personnamn}`);
      if (output.trim()) {
        console.log(`   Output: ${output.trim()}`);
      }

      successCount++;

      // Small delay between requests to be respectful
      await new Promise(resolve => setTimeout(resolve, 2000));

    } catch (error) {
      console.log(`   ✗ Failed to process ${person.personnamn}: ${error.message}`);
      // Continue with next person instead of stopping
    }
  }

  console.log(`\n📊 Ratsit processing complete: ${successCount}/${personsWithPhone.length} persons processed successfully`);
}


async function extractPersonDataFromPage(searchQuery, page) {
  const encodedQuery = encodeURIComponent(searchQuery);
  const url = `https://www.hitta.se/s%C3%B6k?vad=${encodedQuery}&typ=prv&sida=${page}`;

  try {
    const response = await axios.get(url, {
      headers: {
        "User-Agent":
          "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
      },
    });

    const dom = new JSDOM(response.data);
    const document = dom.window.document;

    // Extract hittaPersoner count (only on first page)
    let hittaPersoner;
    if (page === 1) {
      const contentContainers = document.querySelectorAll(
        "span.style_content__nx640",
      );
      for (const container of contentContainers) {
        const titleSpan = container.querySelector("span.style_tabTitle__EC5RP");
        if (titleSpan?.textContent === "Personer") {
          const countSpan = container.querySelector(
            "span.style_tabNumbers__VbAE7",
          );
          const countText = countSpan?.textContent?.trim();
          hittaPersoner = countText ? parseInt(countText, 10) : undefined;
          break;
        }
      }
    }

    // Find all person result rows
    const personItems = document.querySelectorAll(
      'li[itemprop="itemListElement"][data-test="person-item"]',
    );
    const results = [];

    for (const item of personItems) {
      try {
        // Extract name and age
        const titleElement = item.querySelector(
          'h2[data-test="search-result-title"]',
        );
        let personnamn = "";
        let alder = "";

        if (titleElement) {
          const ageSpan = titleElement.querySelector("span.style_age__ZgTHo");
          alder = ageSpan?.textContent?.trim() || "";
          personnamn =
            titleElement.textContent
              ?.replace(ageSpan?.textContent || "", "")
              .trim() || "";
        }

        // Extract gender, address, postal code, city
        const infoParagraph = item.querySelector("p.text-body-long-sm-regular");
        let kon = "";
        let gatuadress = "";
        let postnummer = "";
        let postort = "";

        if (infoParagraph) {
          const lines = infoParagraph.innerHTML.split("<br>");
          const genderSpan = infoParagraph.querySelector(
            "span.style_gender__hKSL0",
          );
          kon = genderSpan?.textContent?.trim() || "";

          if (lines.length >= 2) {
            gatuadress = lines[1]?.trim() || "";
          }
          if (lines.length >= 3) {
            const addressParts = lines[2]?.trim().split(" ") || [];
            if (addressParts.length >= 2) {
              postnummer = addressParts.slice(0, 2).join(" ");
              postort = addressParts.slice(2).join(" ");
            }
          }
        }

        // Extract phone number
        const phoneButton = item.querySelector(
          'button[data-test="phone-link"]',
        );
        let telefon = "";
        if (phoneButton) {
          const phoneText = phoneButton.textContent?.trim() || "";
          // Extract phone number (remove "Visa" text and clean up)
          telefon = phoneText.replace("Visa", "").trim();
        }

        // Extract map link
        const mapButton = item.querySelector(
          'a[data-test="show-on-map-button"]',
        );
        let karta = "";
        if (mapButton) {
          const href = mapButton.getAttribute("href") || "";
          karta = `hitta.se${href}`;
        }

        // Extract person link
        const linkElement = item.querySelector(
          'a[data-test="search-list-link"]',
        );
        let link = "";
        let visa = "";
        let personId = "";

        if (linkElement) {
          const href = linkElement.getAttribute("href") || "";
          link = `https://www.hitta.se${href}`;

          // Extract person ID from link for revealNumber functionality
          // Link format: /joris+frederik+dekkers/j%C3%A4rna/person/dRPZZ___w5
          const linkMatch = href.match(/\/person\/([^\/\?]+)/);
          if (linkMatch) {
            personId = linkMatch[1];
          }
        }

        // Try to get complete phone number from person detail page JSON-LD
        let completeTelefon = telefon;
        // Only fetch detail page if person has a phone number (to avoid unnecessary requests)
        if (
          personId &&
          link &&
          telefon &&
          telefon.trim() &&
          telefon !== "Lägg till telefonnummer"
        ) {
          try {
            const detailResponse = await axios.get(link, {
              headers: {
                "User-Agent":
                  "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36",
              },
              timeout: 10000,
            });

            const detailDom = new JSDOM(detailResponse.data);
            const detailDocument = detailDom.window.document;

            // Extract complete phone number from JSON-LD structured data
            const jsonLdScript = detailDocument.querySelector(
              'script[type="application/ld+json"]',
            );
            if (jsonLdScript) {
              try {
                const jsonLdData = JSON.parse(jsonLdScript.textContent);
                if (jsonLdData.telephone) {
                  completeTelefon = jsonLdData.telephone;
                }
              } catch (e) {
                console.log(
                  `Failed to parse JSON-LD for ${personnamn}: ${e.message}`,
                );
              }
            }

            // Also construct revealNumber URL for reference
            if (telefon && telefon.trim()) {
              const partialMatch = telefon.match(/(\d[\d\s-]*)/);
              if (partialMatch) {
                const partialNumber = partialMatch[1]
                  .replace(/\s/g, "")
                  .replace(/-/g, "");
                visa = `${link}?revealNumber=46${partialNumber}`;
              }
            }
          } catch (error) {
            console.log(
              `Error getting detail page for ${personnamn}: ${error.message}`,
            );
          }
        }

        results.push({
          personnamn,
          alder,
          kon,
          gatuadress,
          postnummer,
          postort,
          telefon: completeTelefon,
          karta,
          link,
          visa,
        });
      } catch (error) {
        console.error("Error processing person item:", error);
      }
    }

    // Check if there's a next page - look for disabled state or absence of next button
    const nextButton = document.querySelector('a[data-ga4-action="next_page"]');
    const hasNextPage =
      !!nextButton && !nextButton.classList.contains("disabled");

    // Also check if we have results on this page
    const hasResults = personItems.length > 0;

    // Additional check: if we have fewer than 25 results, we're likely on the last page
    const isLastPageByCount = personItems.length < 25;

    console.log(
      `Page ${page}: Found ${personItems.length} persons, hasNextPage: ${hasNextPage}, hasResults: ${hasResults}, isLastPageByCount: ${isLastPageByCount}`,
    );

    // Only continue if we have results AND not on last page
    const shouldContinue = hasResults && hasNextPage && !isLastPageByCount;

    return { persons: results, hasNextPage: shouldContinue, hittaPersoner };
  } catch (error) {
    throw new Error(`Failed to fetch or parse Hitta.se page ${page}: ${error}`);
  }
}

async function extractAllPersonData(searchQuery, options = {}) {
  let allPersons = [];
  let currentPage = 1;
  let hasNextPage = true;
  let hittaPersoner = 0;

  console.log(`Starting search for: ${searchQuery}`);

  while (hasNextPage) {
    try {
      console.log(`\n📄 Fetching page ${currentPage}...`);

      const {
        persons,
        hasNextPage: hasMore,
        hittaPersoner: count,
      } = await extractPersonDataFromPage(searchQuery, currentPage);

      // Get hittaPersoner count from first page and display counts
      if (currentPage === 1 && count !== undefined) {
        hittaPersoner = count;
        console.log(`📊 Total persons count: ${hittaPersoner}`);
        const totalPages = Math.ceil(hittaPersoner / 25);
        console.log(`📄 Estimated pages: ${totalPages}`);
      }

      // Save persons from this page immediately to database
      if (persons.length > 0) {
        console.log(`\n💾 Saving page ${currentPage} data (${persons.length} persons)...`);
        try {
          const saveResult = await savePersonsViaApi(persons);

          const totalFailed = (saveResult.failed || 0) + (saveResult.personerDataFailed || 0);
          if (totalFailed > 0) {
            console.log(`⚠️  Warning: ${saveResult.failed || 0} hitta_se + ${saveResult.personerDataFailed || 0} personer_data persons failed to save on page ${currentPage}`);
          } else {
            console.log(`✅ Page ${currentPage} saved successfully!`);
          }

          // If --ratsit flag is enabled, run ratsit for this page's data
          if (options.runRatsit) {
            try {
              await runRatsitForPersons(persons);
            } catch (ratsitError) {
              console.log(`⚠️  Ratsit processing failed for page ${currentPage}: ${ratsitError.message}`);
              // Continue anyway - don't fail the entire scrape
            }
          }
        } catch (saveError) {
          console.log(`❌ Failed to save page ${currentPage} to database: ${saveError.message}`);
          console.log(`⚠️  Continuing with next page...`);
          // Don't stop scraping just because one page failed to save
        }
      }

      // Add to all persons array for final CSV export
      allPersons = allPersons.concat(persons);
      hasNextPage = hasMore;

      currentPage++;

      // Add a small delay to avoid overwhelming the server
      await new Promise((resolve) => setTimeout(resolve, 300));
    } catch (error) {
      console.error(`❌ Error on page ${currentPage}:`, error.message);
      break;
    }
  }

  console.log(`\n✅ Scraping complete! Total persons found: ${allPersons.length}`);
  return { persons: allPersons, hittaPersoner };
}

function saveToCSV(data, filename) {
  const headers = [
    "personnamn",
    "alder",
    "kon",
    "gatuadress",
    "postnummer",
    "postort",
    "telefon",
    "karta",
    "link",
    "visa",
  ];

  const csvLines = [headers.join(",")];

  for (const person of data) {
    const row = [
      `"${(person.personnamn || "").replace(/"/g, '""')}"`,
      `"${(person.alder || "").replace(/"/g, '""')}"`,
      `"${(person.kon || "").replace(/"/g, '""')}"`,
      `"${(person.gatuadress || "").replace(/"/g, '""')}"`,
      `"${(person.postnummer || "").replace(/"/g, '""')}"`,
      `"${(person.postort || "").replace(/"/g, '""')}"`,
      `"${(person.telefon || "").replace(/"/g, '""')}"`,
      `"${(person.karta || "").replace(/"/g, '""')}"`,
      `"${(person.link || "").replace(/"/g, '""')}"`,
      `"${(person.visa || "").replace(/"/g, '""')}"`,
    ];
    csvLines.push(row.join(","));
  }

  const csvContent = csvLines.join("\n");

  // Ensure data directory exists
  const dataDir = path.join(process.cwd(), "data", "csv");
  if (!fs.existsSync(dataDir)) {
    fs.mkdirSync(dataDir, { recursive: true });
  }

  const filepath = path.join(dataDir, filename);
  fs.writeFileSync(filepath, csvContent, "utf8");

  return filepath;
}

function saveDetailsToCSV(data, searchQuery, filename) {
  // Filter results where telefon is NOT "Lägg till telefonnummer"
  const filteredData = data.filter(
    (person) => person.telefon !== "Lägg till telefonnummer",
  );

  const csvLines = filteredData.map((person) => {
    return [
      person.personnamn,
      person.gatuadress,
      searchQuery,
      person.postort,
      person.link,
    ]
      .map((field) => `"${field.replace(/"/g, '""')}"`)
      .join(",");
  });

  const csvContent = csvLines.join("\n");

  // Ensure data directory exists
  const dataDir = path.join(process.cwd(), "data", "csv");
  if (!fs.existsSync(dataDir)) {
    fs.mkdirSync(dataDir, { recursive: true });
  }

  const filepath = path.join(dataDir, filename);
  fs.writeFileSync(filepath, csvContent, "utf8");

  return filepath;
}

const program = new Command();
program
  .name("hittaSearchPersons")
  .description(
    "Extract all person data from Hitta.se search results with pagination and save to database + CSV",
  )
  .argument("<search-query>", "Search query to look up")
  .option("--ratsit", "Run Ratsit scraper for persons with phone numbers after each page")
  .action(async (searchQuery, options) => {
    try {
      console.log("🚀 Starting optimized Hitta.se person search...");
      console.log(`📍 Query: ${searchQuery}`);
      console.log("⚡ SQLite disabled - direct to Filament database");
      if (options.ratsit) {
        console.log("✅ Ratsit mode: ENABLED");
      }

      const result = await extractAllPersonData(searchQuery, {
        runRatsit: options.ratsit || false,
      });
      const { persons: personData, hittaPersoner } = result;

      if (personData.length === 0) {
        console.log("❌ No results found");
        return;
      }

      console.log("\n📊 Final Summary:");
      console.log(`   Total persons scraped: ${personData.length}`);
      console.log(`   Hitta.se total count: ${hittaPersoner || "N/A"}`);

      // Create filename with query and total count
      const sanitizedQuery = searchQuery.replace(/[^a-zA-Z0-9åäöÅÄÖ]/g, "_");
      const filename = `hitta_search_persons_${sanitizedQuery}_total_${personData.length}.csv`;

      console.log("\n💾 Saving CSV files...");
      const filepath = saveToCSV(personData, filename);
      console.log(`✅ Saved all results to: ${filepath}`);

      // Save details CSV with phone number filter
      const detailsFilename = `hitta_search_persons_details_${sanitizedQuery}_total_${personData.length}.csv`;
      const detailsFilepath = saveDetailsToCSV(
        personData,
        searchQuery,
        detailsFilename,
      );
      console.log(`✅ Saved details to: ${detailsFilepath}`);

      console.log("\n✅ All operations completed successfully!");
    } catch (error) {
      console.error("❌ Fatal error:", error.message);
      process.exit(1);
    }
  });

program.parse();
