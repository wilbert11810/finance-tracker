export function getCurrentUser() {
    const raw = localStorage.getItem("user");
    return raw ? JSON.parse(raw) : null;
}

export function logoutUser() {
    localStorage.removeItem("user");
}

export function getUsers() {
    const raw = localStorage.getItem("users");
    return raw ? JSON.parse(raw) : [];
}

export function saveUsers(users) {
    localStorage.setItem("users", JSON.stringify(users));
}
