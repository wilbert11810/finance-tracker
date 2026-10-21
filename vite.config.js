import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vite.dev/config/
export default defineConfig({
  base: "/cos30043/s104323659/finance-project/",
  plugins: [vue()],
  server: {
    proxy: {
      '/cos30043/s104323659/finance-project/backend': {
        target: 'https://mercury.swin.edu.au',
        changeOrigin: true,
        secure: false,
      }
    }
  }
})
