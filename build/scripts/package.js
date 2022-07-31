#!/usr/bin/env node
const _ = require('lodash');
const { getPackageField, fullPath, pkg, getPackageInfo, debug } = require('../webpack/utils/utils');
const path = require('path');
const { pack } = require('npm-pack-zip');
const fs = require('fs-extra');
const AdmZip = require('adm-zip');

function packFiles() {
	const copyDest = getPackageField('config.package.copyPath');
	const releaseDest = getPackageField('config.package.releasePath');
	const packInput = getPackageField('config.package.inputPath');
	const packOutput = getPackageField('config.package.outputPath');
	const packOptions = { source: releaseDest, destination: releaseDest, info: true, verbose: true, addVersion: false, staticDateModified: false };

	const fileList = getPackageField('files');

	fileList.forEach(function (file) {
		const pathToFile = fullPath(file);

		const copyFileDest = path.join(copyDest, file);

		if (!fs.existsSync(copyDest)) {
			fs.mkdirSync(copyDest, { recursive: true });
		}

		try {
			fs.copySync(pathToFile, copyFileDest);
			console.log(`Successfully copied ${file} to ${copyDest}`);
		} catch (err) {
			throw err;
		}
	});

	const pkgData = getPackageInfo();
	_.unset(pkgData, 'devDependencies');
	_.unset(pkgData, '_id');
	_.set(pkgData, 'files', ['rwp']);
	debug(pkgData);

	fs.writeJsonSync(path.join(releaseDest, 'package.json'), pkgData, {
		spaces: '\t',
	});

	const listRegex = _.map(fileList, function (item) {
		const isFile = /\w+\..*$/.test(item);
		if (!isFile) {
			return new RegExp(`^${item}\/`); //eslint-disable-line
		} else {
			return new RegExp(`${item}$`);
		}
	});

	const keepItem = (item) => {
		let keep = false;
		listRegex.forEach(function (pattern) {
			if (pattern.test(item)) {
				keep = true;
			}
		});

		return keep;
	};

	pack(packOptions).then(
		(value) => {
			const zip = new AdmZip(packOutput);

			const zipEntries = zip.getEntries(); // an array of ZipEntry records

			zipEntries.forEach(function (zipEntry) {
				const keepFile = keepItem(zipEntry.entryName);

				if (!keepFile) {
					zip.deleteFile(zipEntry);
				}
			});

			zip.writeZip();

			fs.rmdir(packInput, { recursive: true }, (err) => {
				if (err) {
					throw err;
				}

				console.log(`${packInput} is deleted!`);
			});
		},
		(err) => {
			console.error(err);
		}
	);
}

packFiles();
