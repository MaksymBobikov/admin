import Cookies from 'js-cookie';

export const cookieService = {
    getAuthToken() {
        return Cookies.get('auth_token');
    },

    setAuthToken(token) {
        return Cookies.set('auth_token', token);
    },

    removeAuthToken() {
        return Cookies.set('auth_token', undefined);
    }
}
