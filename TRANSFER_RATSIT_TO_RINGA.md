# Transfer Ratsit Data to Ringa Data

## Overview

This feature provides a bulk action to transfer selected records from the Ratsit Data table to the Ringa Data table. This is useful when you want to move contacts from the external Ratsit database into your own Ringa tracking system.

## Features

- **Bulk Transfer**: Select multiple Ratsit Data records and transfer them all at once
- **Data Preservation**: All data fields are properly copied, including arrays and complex types
- **Automatic Metadata**: User ID and Team ID are automatically set based on the current context
- **Confirmation**: The action requires confirmation before executing to prevent accidental transfers
- **Success Notification**: Users receive feedback showing how many records were transferred

## Location

**URL**: `http://localhost:8000/nds/data/databaser/ratsit-data`

The bulk action button appears in the table toolbar.

## How to Use

1. Navigate to the Ratsit Data table: `http://localhost:8000/nds/data/databaser/ratsit-data`

2. Select one or more records using the checkboxes on the left side of each row

3. In the toolbar that appears below the table, click the **"Transfer to Ringa Data"** button (green button with arrow icon)

4. Confirm the action when prompted

5. A success notification will appear showing the number of records transferred

## Technical Implementation

### Action Class
Location: [app/Actions/TransferRatsitDataToRingaDataAction.php](app/Actions/TransferRatsitDataToRingaDataAction.php)

The action handles:
- Transferring records in a database transaction for data integrity
- Copying all relevant fields from RatsitData to RingaData
- Setting default values for new fields (status: null, outcome: null, attempts: 0)
- Preserving complex data types (arrays, dates, etc.)

```php
$action = new TransferRatsitDataToRingaDataAction();
$action->handle($records, ['user_id' => 123, 'team_id' => 456]);
```

### Bulk Action Configuration
Location: [app/Filament/Data/Resources/RatsitDatas/Tables/RatsitDatasTable.php](app/Filament/Data/Resources/RatsitDatas/Tables/RatsitDatasTable.php)

The bulk action is configured with:
- Label: "Transfer to Ringa Data"
- Icon: Arrow right icon
- Color: Success (green)
- Confirmation required: Yes
- Auto-popup notification on success

### Data Fields Transferred

All fields from RatsitData are copied to RingaData:
- Personal info: personnamn, personnummer, fornamn, efternamn, alder, kon, fodelsedag, civilstand, stjarntacken
- Address: gatuadress, postnummer, postort, forsamling, kommun, lan, adressandring
- Contact: telefon, telfonnummer, epost_adress
- Property: agandeform, bostadstyp, boarea, byggar, fastighet
- Collections: personer, foretag, grannar, fordon, hundar, bolagsengagemang
- Links: google_maps, google_streetview, ratsit_se
- Flags: is_active, is_telefon, is_hus, is_queued
- Defaults: user_id (from context), team_id (from context), status (null), outcome (null), attempts (0)

## Testing

Tests are located at: [tests/Feature/TransferRatsitDataToRingaDataTest.php](tests/Feature/TransferRatsitDataToRingaDataTest.php)

Run tests with:
```bash
php artisan test tests/Feature/TransferRatsitDataToRingaDataTest.php
```

Test coverage includes:
- Basic transfer functionality
- Data type preservation (arrays, booleans, etc.)
- Default value assignment
- Multiple record transfers

## Database Schema

### RatsitData Table
- Stores external Ratsit database records
- `ratsit_data` table
- Does not have user_id or team_id by default

### RingaData Table  
- Stores internal call tracking records
- `ringa_data` table
- Includes user_id, team_id for multi-tenancy
- Includes outcome, status, attempts for call tracking

## Error Handling

The action uses database transactions to ensure data integrity. If any error occurs during the transfer of a batch of records, the entire transaction is rolled back and no records are transferred.

## Related Resources

- [RatsitData Model](app/Models/RatsitData.php)
- [RingaData Model](app/Models/RingaData.php)
- [RatsitDataResource](app/Filament/Data/Resources/RatsitDatas/RatsitDataResource.php)
- [RingaDataResource](app/Filament/App/Resources/RingaDatas/RingaDatasResource.php)

## Future Enhancements

Possible improvements:
- Add a selective field transfer option (transfer only specific fields)
- Add duplicate detection to prevent transferring records that already exist in RingaData
- Add batch operation history/audit log
- Add scheduling for automated transfers
