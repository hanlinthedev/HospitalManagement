import api from "./api";

export const authApi = {
	login: async (email: string, password: string) => {
		const response = await api.post("/auth/signin", { email, password });
		return response.data;
	},

	register: async (email: string, password: string) => {
		const response = await api.post("/auth/signup", {
			email,
			password,
		});
		return response.data;
	},

	logout: async () => {
		const response = await api.post("/auth/logout");
		return response.data;
	},
};
