#!/usr/bin/env node
const _ = require('lodash');
const { getPackageField } = require('../webpack/utils/utils');
const path = require('path');
const { pack } = require('npm-pack-zip');
const fs = require('fs-extra');
const AdmZip = require('adm-zip');

function packFiles() {
	const dest = path.join(process.cwd(), 'release');
	const packOptions = { source: process.cwd(), destination: dest, info: true, verbose: false, addVersion: false, staticDateModified: false };
	const fileList = getPackageField('files');

	fileList.then(
		(list) => {
			const listRegex = _.map(list, function (item) {
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
					const zip = new AdmZip(path.join(dest, 'rwp.zip'));
					const zipEntries = zip.getEntries(); // an array of ZipEntry records

					zipEntries.forEach(function (zipEntry) {
						const keepFile = keepItem(zipEntry.entryName);

						if (!keepFile) {
							zip.deleteFile(zipEntry);
						}
					});

					zip.writeZip();
				},
				(err) => {
					console.error(err);
				}
			);
		},
		(err) => {
			console.error(err);
		}
	);
}

packFiles();
