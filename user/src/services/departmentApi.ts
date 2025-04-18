import api from "./api";

export const departmentApi = {
	getDepartment: async () => {
		const response = await api.get("/departments");
		return response.data.data;
	},
	getDepartmentById: async (id: string) => {
		const response = await api.get(`/departments/${id}`);
		return response.data.data;
	},
};
