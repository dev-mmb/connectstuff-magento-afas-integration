import * as child from "child_process";
const { version } = require("./package.json");

const zipName = `connectstuff_magento-afas-integration_${version}.zip`;
child.execSync("mkdir -p bin", { encoding: "utf-8" });
child.execSync("mkdir -p bin/etc", { encoding: "utf-8" });
child.execSync("mkdir -p bin/Observer", { encoding: "utf-8" });

child.execSync("cp ./etc/* ./bin/etc", { encoding: "utf-8" });
child.execSync("cp ./Observer/* ./bin/Observer", { encoding: "utf-8" });
child.execSync("cp ./composer.json ./bin", { encoding: "utf-8" });
child.execSync("cp ./registration.php ./bin", { encoding: "utf-8" });

child.execSync(`cd bin; zip -r ${zipName} ./*; cd ..`, { encoding: "utf-8" });

child.execSync(`cp ./bin/${zipName} ./`, { encoding: "utf-8" });

child.execSync(`rm -rf ./bin`, { encoding: "utf-8" });
