import { configureStore } from "@reduxjs/toolkit";
import authReducer from "./slices/authSlice";
import departmentReducer from "./slices/departmentSlice";
import homeReducer from "./slices/homeSlice";

export const store = configureStore({
	reducer: {
		auth: authReducer,
		home: homeReducer,
		departments: departmentReducer,
	},
});

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;
