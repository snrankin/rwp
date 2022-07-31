#!/usr/bin/env node
const _ = require('lodash');
const { getPackageField, fullPath } = require('../webpack/utils/utils');
const path = require('path');
const { pack } = require('npm-pack-zip');
const fs = require('fs-extra');
const AdmZip = require('adm-zip');

function packFiles() {
	const dest = path.join(process.cwd(), 'release');
	const newPath = path.join(dest, 'rwp');
	const packOptions = { source: dest, destination: dest, info: true, verbose: false, addVersion: false, staticDateModified: false };
	const fileList = getPackageField('files');

	fileList
		.then((list) => {
			list.forEach((file) => {
				const pathToFile = fullPath(file);

				const pathToNewDestination = path.join(newPath, 'rwp', file);

				if (!fs.existsSync(newPath)) {
					fs.mkdirSync(newPath, { recursive: true });
				}

				try {
					const relDest = path.relative(process.cwd(), pathToNewDestination);
					fs.copySync(pathToFile, pathToNewDestination);
					console.log(`Successfully copied ${file} to ${relDest}`);
				} catch (err) {
					throw err;
				}
			});
			// edit JSON as string
			return list;
		})
		.then(
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

						fs.rmdir(newPath, { recursive: true }, (err) => {
							if (err) {
								throw err;
							}

							console.log(`${newPath} is deleted!`);
						});
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
