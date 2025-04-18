import api from "./api";

export const homeApi = {
	getData: async () => {
		const response = await api.get("/home");
		return response.data;
	},
};
