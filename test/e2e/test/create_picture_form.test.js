import { SERVER_URL } from "../config";
import { DEMO_USER, GUEST } from "../roles";
import PagePictureCreate from "../page-objects/PagePictureCreate";
import { resetDB, resetUploads } from "../../util/testUtils";
const fs = require('fs-extra');
const path = require('path');

fixture("create picture form")
    .page(SERVER_URL)
    .before(async ctx => {
        resetDB();
        resetUploads();
    })
    .beforeEach(async t => {
        await t.useRole(DEMO_USER);
    })
    .afterEach(async t => {
        await t.useRole(GUEST);
    });


test('upload new picture via create form', async t => {
    let page = await PagePictureCreate(t).navigateGemaeldeHinzufuegenNavbar();
    await page.setTitle("Ein neues Gemälde");
    await page.checkTitle("Ein neues Gemälde");
    await page.setMaterial("Acryl auf Leinwand");
    await page.checkMaterial("Acryl auf Leinwand");
    await page.setDescription("Eine Beschreibung des Gemäldes");
    await page.checkDescription("Eine Beschreibung des Gemäldes");


    //create exhibition and check fields
    let dialog = await page.neueAusstellungAnlegen();
    await dialog.setCategoryName("Ausstellung");
    await dialog.checkCategoryName("Ausstellung");
    await dialog.setCategoryDescription("Eine Beschreibung der Ausstellung");
    await dialog.checkCategoryDescription("Eine Beschreibung der Ausstellung");
    await dialog.clickAusstellungAnlegenBtn();

    // create unique upload file
    const filename = path.resolve(__dirname, `../pictures/${`twitter-${Math.random() * 100}.png`}`);
    await fs.copy(path.resolve(__dirname, '../pictures/twitter.png'), filename);

    await page.setFilesToUpload(filename);
    await page.clickAddPicSubmit();
    await page.checkAlertSuccess("Das Bild wurde erfolgreich hinzugefügt.");

    // remove the file again
    await fs.remove(filename)
});