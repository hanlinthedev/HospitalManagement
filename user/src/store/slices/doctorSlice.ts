import { DoctorData, Doctor } from "@/types";
import { createSlice, PayloadAction } from "@reduxjs/toolkit";

const initialState: { doctors: DoctorData["doctor_profile"][] } = {
    doctors: [],
};

const doctorSlice = createSlice({
    name: "doctor",
    initialState,
    reducers: {
        setDoctors: (state, action: PayloadAction<Doctor[]>) => {
            state.doctors = action.payload;
        },
    },
});

export default doctorSlice.reducer;
export const { setDoctors } = doctorSlice.actions;
