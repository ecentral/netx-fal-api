# Fairway NetX PHP SDK

PHP SDK for the **NetX JSON-RPC API**.
Includes services for Assets, Folders, Collections, Attributes, Search, Versions, Views, Misc, and File Import.

```NetX Postman
https://developer.netx.net/#postman
```

---

## Installation

```bash
composer require fairway/netx-fal-api
```

---

## Getting Started

```php
use Fairway\NetXFalApi\Client;

$client = new Client('https://your-netx-host', 'YOUR_API_TOKEN');
```

---

## Examples

### Assets

```php
// Fetch assets
$assets = $client->assets->getAssets([17901, 17902]);
foreach ($assets as $asset) {
    echo $asset->id . ': ' . $asset->name . PHP_EOL;
}

// Update an asset
$updated = $client->assets->updateAsset(17901, ['name' => 'New Name']);
echo "Updated: " . $updated->name . PHP_EOL;

// Delete an asset
$client->assets->deleteAsset(17902);
```

---

### Folders

```php
// Create a new folder
$newFolder = $client->folders->createFolder('My Uploads');

// List root folders
$roots = $client->folders->getRootFolders();
foreach ($roots as $folder) {
    echo $folder->id . ': ' . $folder->name . PHP_EOL;
}
```

---

### Collections

```php
// Create a new collection
$collection = $client->collections->createCollection('My Collection', 'Description');

// Fetch collection by ID
$found = $client->collections->getCollectionById($collection->id);
echo $found->name . PHP_EOL;

// Add an asset to the collection
$client->collections->addAssetToCollection($collection->id, 17901);
```

---

### Attributes

```php
// Fetch all attributes
$attributes = $client->attributes->getAttributes();
foreach ($attributes as $attr) {
    echo $attr->id . ': ' . $attr->label . PHP_EOL;
}
```

---

### Search

```php
// Search for assets
$results = $client->search->searchAssets('demo');
foreach ($results as $asset) {
    echo $asset->id . ': ' . $asset->name . PHP_EOL;
}
```

---

### Versions

```php
// Get versions of an asset
$versions = $client->versions->getVersionsByAsset(17901);
foreach ($versions as $version) {
    echo 'Version ' . $version->versionNumber . ' of ' . $version->fileName . PHP_EOL;
}
```

---

### Views

```php
// Get views for an asset
$views = $client->views->getViewsByAsset(17901);
foreach ($views as $view) {
    echo $view->type . ' → ' . $view->url . PHP_EOL;
}
```

---

### Misc

```php
// Get API version
echo "API Version: " . $client->misc->getVersion() . PHP_EOL;

// Get storage locations
$locations = $client->misc->getLocations();
foreach ($locations as $loc) {
    echo $loc->id . ': ' . $loc->name . PHP_EOL;
}
```

---

### File Import

```php
// Upload a new asset
$newAsset = $client->fileImport->importAsset('/path/to/file.jpg', 1234);
echo "Asset created with ID " . $newAsset->id . PHP_EOL;

// Upload a new version for an asset
$updated = $client->fileImport->versionAsset($newAsset->id, '/path/to/newfile.jpg');
echo "New version created for asset " . $updated->id . PHP_EOL;
```
