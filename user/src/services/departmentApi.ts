import api from "./api";

export const departmentApi = {
	getDepartment: async () => {
		const response = await api.get("/departments");
		return response.data;
	},
};
