import { reactive } from "vue";
import { api } from "../api";

// Shared auth state. The router guard calls getCurrentUser() on every navigation,
// so the navbar (bound to auth.user) stays in sync after login and logout without
// a page reload.
export const auth = reactive({ user: null });

export async function getCurrentUser() {
  try {
    const response = await api.get("/session.php");
    auth.user = response.data.user || null;
  } catch (error) {
    console.error("Error fetching session:", error);
    auth.user = null;
  }
  return auth.user;
}

export async function logoutUser() {
  await api.get("/logout.php");
  auth.user = null;
  localStorage.removeItem("user");
}
