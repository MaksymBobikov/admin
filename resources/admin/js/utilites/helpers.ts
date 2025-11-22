interface dataParam {
    [field: string]: any;
}

export function generateUrl(url: string, data: dataParam = {}): string {
    const params = new URLSearchParams();
    const keys = Object.keys(data);

    if (keys.length > 0) {
        keys.forEach((key) => {
            params.append(key, data[key]);
        });
    }

    return url + (keys.length > 0 ? '?' + params.toString() : '');
}

export function redirectTo(url: string, data: dataParam = {}) {
    const targetUrl = generateUrl(url, data);

    window.location.replace(targetUrl);
}

export function pushHistory(targetUrl: string) {
    history.pushState({}, '', targetUrl);
}
