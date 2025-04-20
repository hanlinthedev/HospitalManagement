import { departmentApi } from "@/services";
import { RootState } from "@/store";
import { setDepartments } from "@/store/slices/departmentSlice";

import { useQuery } from "@tanstack/react-query";
import { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";

export const useDepartment = () => {
    const dispatch = useDispatch();
    const { departments } = useSelector(
        (state: RootState) => state.departments
    );
    const { data, isLoading } = useQuery({
        queryKey: ["departments"],
        queryFn: departmentApi.getDepartment,
    });
    useEffect(() => {
        if (data) {
            dispatch(setDepartments(data));
        }
    }, [data, dispatch, isLoading]);
    return {
        departments,
        isLoading,
    };
};
