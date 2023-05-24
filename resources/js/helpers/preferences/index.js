export const setPrefersDarkMode = (prefersDarkMode = null, persist = false) => {
    if (prefersDarkMode !== null && persist) {
        localStorage.setItem('darkMode', prefersDarkMode);
    }

    prefersDarkMode = prefersDarkMode ?? (localStorage.getItem('darkMode') === 'true' || window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)

    if (prefersDarkMode) {
        document.querySelector('html').classList.add('dark');
        return
    }

    document.querySelector('html').classList.remove('dark');
}

// setPrefersDarkMode(true, true)
