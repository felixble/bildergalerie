import { Role } from 'testcafe';
import { SERVER_URL, USER_NAME, PASSWORD } from "./config.js";

import createPageLogin, { PAGE_LOGIN_URL } from "./page-objects/PageLogin.js";

export const GUEST = Role(`${SERVER_URL}/auth/logout`, async t => {
    // nothing to do
});


export const DEMO_USER = Role(PAGE_LOGIN_URL, async t => {
    const pageLogin = createPageLogin(t);
    await pageLogin.setBenutzername(USER_NAME);
    await pageLogin.setPasswort(PASSWORD);
    await pageLogin.clickAnmelden();
}); 