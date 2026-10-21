<template>
  <div class="container mt-4">
    <div class="card border shadow-sm p-4">
      <h2 class="text-center">Sign In</h2>
      <p class="text-muted text-center">Access your financial dashboard</p>

      
      <form @submit.prevent="loginUser">
        <div class="mb-3">
          <label>Email</label>
          <input type="email" v-model="email" class="form-control" placeholder="Enter your email">
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input type="password" v-model="password" class="form-control" placeholder="Enter password">
        </div>

        
        <div v-if="isLoading" class="text-center mt-2">
          <div class="spinner-border text-primary" role="status"></div>
          <p>Logging in...</p>
        </div>

        <button type="submit" class="btn btn-primary w-100" :disabled="isLoading">
          {{ isLoading ? "Logging in..." : "Login" }}
        </button>
      </form>
      <p v-if="errorMessage" class="error"> {{ errorMessage }}</p>
    </div>
  </div>
</template>


<script>
import { getCurrentUser, getUsers } from "../utils/auth.js";

export default {
  data() {
    return {
        email: "",
        password: "",
        errorMessage: "",
        isLoading: false
    };
  },
  mounted() {
    if (getCurrentUser()) {
      this.$router.push("/cos30043/s104323659/finance-project/");
    }
  },
  methods: {
    loginUser() {
        if (!this.email || !this.password) {
            this.errorMessage = "Email or password cannot be empty";
            return;
        }
        this.isLoading = true;
        const users = getUsers();
        const match = users.find(u => u.email === this.email && u.password === this.password);
        if (match) {
            localStorage.setItem("user", JSON.stringify(match));
            alert("Logged in successfully!");
            this.$router.push("/cos30043/s104323659/finance-project/");
            this.errorMessage = "";
        } else {
            this.errorMessage = "Invalid email or password.";
        }
        this.isLoading = false;
    }
  }
};
</script>
