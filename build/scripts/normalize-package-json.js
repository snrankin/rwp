#!/usr/bin/env node

const { getPackageInfo, debug, pkg } = require('../webpack/utils/utils');
const fs = require('fs-extra');
const pkgData = getPackageInfo();
delete pkgData._id;
debug(pkgData);

fs.writeJsonSync(pkg, pkgData, {
	spaces: '\t',
});
