import { Selector } from "testcafe";

const neueAusstellungDialog = (t) => {
    return {

        async setCategoryName(value){
            await t.typeText("#category_name", value);
        },
        async checkCategoryName(value){
            const category_name = await Selector("#category_name").value;
            await t.expect(category_name).contains(value);
        },
        async setCategoryDescription(value){
            await t.typeText("#category_description", value);
        },
        async checkCategoryDescription(value){
            const category_description = await Selector("#category_description").value;
            await t.expect(category_description).contains(value);
        },
        async clickAusstellungAnlegenBtn(){
            await t.click("#dialog-save-ausstellung-btn");
        }
    }
};

export default function (t) {
    return {
        /**
         * use the navbar to visit the 'Backend'-Page.
         * @returns Promise for the Page-Object of 'Backend'-Page
         */
        async navigateGemaeldeHinzufuegenNavbar() {
            await t
                .click("#nav_pictures > a")
                .click("#nav_pictures_create > a")
                return {
                    async setTitle(value) {
                        await t.typeText("#title", value);
                    },
                    async checkTitle(value) {
                        const title = await Selector("#title").value;
                        await t.expect(title).eql(value);
                    },
                    async setMaterial(value) {
                        await t.typeText("#material", value);
                    },
                    async checkMaterial(value) {
                        const material = await Selector("#material").value;
                        await t.expect(material).contains(value);
                    },
                    async setDescription(value) {
                        await t.typeText("#description", value);
                    },
                    async checkDescription(value) {
                        const description = await Selector("#description").value;
                        await t.expect(description).contains(value);
                    },
                    async neueAusstellungAnlegen(){
                        await t.click("#btn_neue_ausstellung");
                        return neueAusstellungDialog(t);
                    },
                    async setFilesToUpload(filename){
                        await t.setFilesToUpload("#uploadFile",filename);
                    },
                    async clickAddPicSubmit(){
                        await t.click("#add_pic_submit");
                    },
                    async checkAlertSuccess(value){
                        await t.expect(Selector(".alert-success"). innerText).contains(value);
                    }
                }
        }
    };
};


