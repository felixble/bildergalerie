import { Selector } from 'testcafe';
import { SERVER_URL } from "../config.js";

export const PAGE_LOGIN_URL = `${SERVER_URL}/backend`;

export default function createPageObject(t) {
    return {
        async setBenutzername(value) {
            await t.typeText('#inputUser', value);
        },
        async setPasswort(value) {
            await t.typeText('#inputPassword', value);
        },
        async clickAnmelden() {
            await t.click(Selector("button"));
        }
    };
}; 