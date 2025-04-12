import axios from "axios";

const API_URL = "http://localhost:8000/api";

const api = axios.create({
	baseURL: API_URL,
	withCredentials: true, // Important for cookies
});

// Request interceptor to add auth token
api.interceptors.request.use(
	(config) => {
		const token = localStorage.getItem("accessToken");
		if (token) {
			config.headers.Authorization = `Bearer ${token}`;
		}
		return config;
	},
	(error) => {
		return Promise.reject(error);
	}
);

// Response interceptor to handle token refresh
api.interceptors.response.use(
	(response) => response,
	async (error) => {
		const originalRequest = error.config;

		if (
			error.response.status === 401 &&
			error.response.data.message !== "Invalid credentials" &&
			!originalRequest._retry
		) {
			originalRequest._retry = true;

			try {
				const response = await api.post("/auth/refresh");
				const { accessToken } = response.data;

				localStorage.setItem("accessToken", accessToken);
				api.defaults.headers.common["Authorization"] = `Bearer ${accessToken}`;

				return api(originalRequest);
			} catch (refreshError) {
				// Handle refresh token error (e.g., redirect to login)
				localStorage.removeItem("accessToken");
				window.location.href = "/login";
				return Promise.reject(refreshError);
			}
		}

		return Promise.reject(error);
	}
);

export default api;
