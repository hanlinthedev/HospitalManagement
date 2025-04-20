import { Department, Doctor } from "@/types";
import { createSlice } from "@reduxjs/toolkit";

interface HomeState {
    departments: Department[];
    doctors: Doctor[];
}

const initialState: HomeState = {
    departments: [],
    doctors: [],
};

const homeSlice = createSlice({
    name: "home",
    initialState,
    reducers: {
        setData(state, action) {
            console.log(action.payload);
            state.departments = action.payload.departments;
            state.doctors = action.payload.doctors;
        },
    },
});

export const { setData } = homeSlice.actions;
export default homeSlice.reducer;
