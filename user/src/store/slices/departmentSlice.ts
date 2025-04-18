import { Department } from "@/types";
import { createSlice, PayloadAction } from "@reduxjs/toolkit";

const initialState: { departments: Department[] } = {
	departments: [],
};

const departmentSlice = createSlice({
	name: "department",
	initialState,
	reducers: {
		setDepartments: (state, action: PayloadAction<Department[]>) => {
			state.departments = action.payload;
		},
	},
});

export default departmentSlice.reducer;
export const { setDepartments } = departmentSlice.actions;
