import { doctorApi } from "../services/doctorApi";
import { RootState } from "@/store";
import { setDoctors } from "../store/slices/doctorSlice";
import { useQuery } from "@tanstack/react-query";
import { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import { Doctor } from "@/types";

export const useDoctor = () => {
    const dispatch = useDispatch();
    const { doctors } = useSelector((state: RootState) => state.doctors);
    const { data, isLoading } = useQuery({
        queryKey: ["doctors"],
        queryFn: doctorApi.getDoctor,
    });
    useEffect(() => {
        if (data) {
            const doctorProfiles: Doctor[] = data.map(
                (item: { doctor_profile: Doctor }) => item.doctor_profile
            );
            dispatch(setDoctors(doctorProfiles));
        }
    }, [data, dispatch, isLoading]);
    return {
        doctors,
        isLoading,
    };
};
