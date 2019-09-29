import { Selector } from "testcafe";

const createTabAusstellungen = (t) => {
    return {
        /**
         * Check, if the exhibition with the given name is present on screen
         * @param {*} name e.g. "Bilder 2018"
         */
        async checkAusstellungWirdAngezeigt(name) {
            const text = await Selector("#exhibition_table_body").innerText;
            await t.expect(text).contains(name);
        },
        /**
         * Check if the exhibition with the given name is not present on screen
         * @param {*} name the name of the exhibition
         */
        async checkKeineAusstellungWirdAngezeigt(name) {
            const tableExists = await Selector("#exhibition_table_body").exists;
            await t.expect(tableExists).notOk();
        },
        /**
         * Clicks the button to delete a exhibition
         */
        async deleteAusstellung() {
            await t.setNativeDialogHandler(() => true)
                .click(".deleteExhibition");
        },
        /**
         * Clicks the button to create a new exhibition (which will show a dialog)
         * @returns Promise for the Page-Object of the 'Neue Ausstellung hinzufügen'-Dialog
         */
        async clickNeueAustellung() {
            await t.click("button.open_category_dialog");
            return {
                async setTitel(value) {
                    await t.typeText("#category_name", value);
                },
                async setBeschreibung(value) {
                    await t.typeText("#category_description", value);
                },
                async clickAnlegen() {
                    await t.click("#dialog-save-ausstellung-btn");
                },
                async clickAbbrechen() {
                    throw new Error("nicht implementiert");
                }
            }
        },
			/**
			 * Open edit page of the exhibiton with the given name
			 * @param name of the exhibition
			 */ 
			async clickEditAusstellung(name){
				const tableSelect = await Selector("#exhibition_table_body");
				const row = await tableSelect.find('tr').withText(name).find(".glyphicon.glyphicon-pencil"); 
				await t.click(row);
				return {
                async setTitel(value) {
                    await t.typeText("#category_name", value, {replace:true});
                },
                async setBeschreibung(value) {
                    await t.typeText("#category_description", value, {replace:true});
                },
                async clickAnlegen() {
                    await t.click("#dialog-save-ausstellung-btn");
                },
                async clickAbbrechen() {
                    throw new Error("nicht implementiert");
                }
            }
		}
    }
};

export default function (t) {
    return {
        /**
         * use the navbar to visit the 'Backend'-Page. 
         * @returns Promise for the Page-Object of 'Backend'-Page
         */
        async navigateToViaNavbar() {
            await t.click("#nav_backend > a");
            return {
                /**
                 * There is a Tab-View with "Ausstellungen", "Gemälde", "News". Via
                 * the chooseXYZ-Functions you can get the Page-Object for the choosen tab.
                 */
                tabs: {
                    /**
                     * Choose the Tab 'Ausstellungen' and get its Page-Object
                     * @returns Promise for the Page-Object
                     */
                    async chooseAusstellungen() {
                        await t.click("#tab_exhibitions > a");
                        return createTabAusstellungen(t)
                    },
                    /**
                     * Choose the Tab 'Gemälde' and get its Page-Object
                     * @returns Promise for the Page-Object
                     */
                    async chooseGemaelde() {
                        await t.click("#tab_pictures > a");
                        return {
                            async uploadGemaelde() {
                                console.log("upload gemaelde");
                            }
                        };
                    },
                    /**
                     * Choose the Tab 'News' and get its Page-Object
                     * @returns Promise for the Page-Object
                     */
                    async chooseNews() {

                    }
                }
            }
        }
    };
};


