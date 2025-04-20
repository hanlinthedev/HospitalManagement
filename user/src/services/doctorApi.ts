import api from "./api";

export const doctorApi = {
    getDoctor: async () => {
        const response = await api.get("/doctors");
        return response.data.data;
    },
    getDoctorById: async (id: string) => {
        const response = await api.get(`/doctors/${id}`);
        return response.data.data;
    },
};
