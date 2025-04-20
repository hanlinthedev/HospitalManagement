import { configureStore } from "@reduxjs/toolkit";
import authReducer from "./slices/authSlice";
import departmentReducer from "./slices/departmentSlice";
import homeReducer from "./slices/homeSlice";
import doctorReducer from "./slices/doctorSlice";

export const store = configureStore({
    reducer: {
        auth: authReducer,
        home: homeReducer,
        departments: departmentReducer,
        doctors: doctorReducer,
    },
});

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;
