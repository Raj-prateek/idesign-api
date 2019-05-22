// // 'use strict';

const loopback = require('loopback');
const promisify = require('util').promisify;
const fs = require('fs');
const writeFile = promisify(fs.writeFile);
const readFile = promisify(fs.readFile);
const mkdirp = promisify(require('mkdirp'));

const DATASOURCE_NAME = 'MYServer';
const dataSourceConfig = require('../datasources.json');
const db = new loopback.DataSource(dataSourceConfig[DATASOURCE_NAME]);
const tables=["country","city","user","item_type","input_type","requirement"];

async function discover() {
  for(table in tables){
    // It's important to pass the same "options" object to all calls
    // of dataSource.discoverSchemas(), it allows the method to cache
    // discovered related models
    const options = {relations: true};
    // Discover models and relations
    const inventorySchemas = await db.discoverSchemas(tables[table], options);
    // Create model definition files
    await mkdirp('common/models');
    await writeFile(
    'common/models/'+tables[table]+'.json',
    JSON.stringify(inventorySchemas['clothes.'+tables[table]], null, 2)
    );
    // Expose models via REST API
    const configJson = await readFile('server/model-config.json', 'utf-8');
    console.log('MODEL CONFIG', configJson);
    const config = JSON.parse(configJson);
    config[tables[table]] = {dataSource: DATASOURCE_NAME, public: true};
    await writeFile(
    'server/model-config.json',
    JSON.stringify(config, null, 2)
    );
  }
}

// discover().then(
//   success => process.exit(),
//   error => { console.error('UNHANDLED ERROR:\n', error); process.exit(1); },
// );