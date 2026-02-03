## Quick Start Guide - Transfer Ratsit Data to Ringa Data

### Location
**URL:** http://localhost:8000/nds/data/databaser/ratsit-data

### Step-by-Step Usage

#### 1. Open the Ratsit Data Table
Navigate to: http://localhost:8000/nds/data/databaser/ratsit-data

You'll see a table with all Ratsit database records.

#### 2. Select Records
- Use the **checkboxes** on the left side of each row to select records
- You can select one or multiple records
- Selected rows will be highlighted

#### 3. Click Transfer Button
Once records are selected, a toolbar appears below the table with action buttons:
- **Export** - Export selected records
- **Transfer to Ringa Data** ← This is the button you want! (Green with arrow icon)
- **Delete** - Delete selected records

Click the **Transfer to Ringa Data** button.

#### 4. Confirm Action
A confirmation dialog will appear:
- Shows the number of records to be transferred
- Click **"Confirm"** to proceed, or **"Cancel"** to abort

#### 5. Success Notification
After confirmation, you'll see a success message:
```
Success
X records transferred to Ringa Data
```

The records have now been copied from the Ratsit database to your Ringa Data tracking system!

---

## What Happens During Transfer?

When you transfer records, the system:

✅ Copies all personal information (name, ID number, dates, gender, etc.)  
✅ Copies all address information (street, postal code, city, county, etc.)  
✅ Copies all contact information (phone numbers, emails)  
✅ Copies all property information (ownership, housing type, area, etc.)  
✅ Copies all related data (people, companies, neighbors, vehicles, dogs, board positions)  
✅ Copies all links (Google Maps, Street View, Ratsit profile)  
✅ Preserves all flags (active status, phone/house flags, queue status)  
✅ Automatically sets your user ID  
✅ Automatically sets your team ID (if using multi-tenant)  
✅ Initializes tracking fields (status: pending, outcome: none, attempts: 0)  

All this happens in a single database transaction, ensuring data integrity.

---

## Important Notes

⚠️ **One-Way Transfer:** Records are copied, not moved. Original records remain in Ratsit Data.

⚠️ **No Duplicates by Default:** The system does not check for existing records. If you transfer the same record twice, you'll get duplicates.

✅ **Confirmation Required:** The system asks you to confirm before transferring to prevent accidents.

✅ **Bulk Operation:** You can transfer many records at once (tested with up to 100+ records).

✅ **Automatic Context:** User ID and Team ID are set automatically from your current session.

---

## Viewing Transferred Records

After transfer, you can view the records in the Ringa Data table:
- URL: http://localhost:8000/app/ringa/data
- Or from the sidebar: **Mina Sidor → Nummer → Återkomsten**

Look for records matching the ones you just transferred.

---

## Troubleshooting

**Q: I don't see the "Transfer to Ringa Data" button**
A: Make sure you have selected at least one record. The button only appears when records are selected.

**Q: The transfer failed with an error**
A: The system uses transactions, so if anything fails, no records are transferred. The error message should explain what went wrong.

**Q: I transferred the same records twice and now have duplicates**
A: The system copies records, it doesn't check for duplicates. You may want to delete the duplicate in Ringa Data or add duplicate detection in the future.

**Q: Can I undo a transfer?**
A: Records in Ratsit Data are not deleted during transfer. Original records remain, but the copied records in Ringa Data would need to be deleted manually if needed.

---

## For Developers

See the following files for implementation details:

- [TRANSFER_RATSIT_TO_RINGA.md](TRANSFER_RATSIT_TO_RINGA.md) - Complete technical documentation
- [IMPLEMENTATION_SUMMARY.md](IMPLEMENTATION_SUMMARY.md) - Implementation overview
- [app/Actions/TransferRatsitDataToRingaDataAction.php](app/Actions/TransferRatsitDataToRingaDataAction.php) - Action class
- [app/Filament/Data/Resources/RatsitDatas/Tables/RatsitDatasTable.php](app/Filament/Data/Resources/RatsitDatas/Tables/RatsitDatasTable.php) - Bulk action configuration
- [tests/Feature/TransferRatsitDataToRingaDataTest.php](tests/Feature/TransferRatsitDataToRingaDataTest.php) - Test suite

Run tests:
```bash
php artisan test tests/Feature/TransferRatsitDataToRingaDataTest.php
```

---

**Feature Created:** February 3, 2026  
**Status:** ✅ Complete and Ready for Use
