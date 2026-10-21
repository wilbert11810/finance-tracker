import { api } from "../api";

export async function getCurrentUser() {
  try {
    const response = await api.get("/session.php");
    return response.data.user || null;
  } catch (error) {
    console.error("Error fetching session:", error);
    return null;
  }
}

export async function logoutUser() {
  await api.get("/logout.php");
  localStorage.removeItem("user");
}
