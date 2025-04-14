import { homeApi } from "@/services";
import { RootState } from "@/store";
import { setData } from "@/store/slices/homeSlice";
import { useQuery } from "@tanstack/react-query";
import { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";

export const useHome = () => {
	const dispatch = useDispatch();
	const { departments, doctors } = useSelector(
		(state: RootState) => state.home
	);
	const { data, isLoading } = useQuery({
		queryKey: ["home"],
		queryFn: homeApi.getData,
	});
	console.log(data);
	useEffect(() => {
		if (data) {
			console.log(data);
			dispatch(setData(data));
		}
	}, [data, dispatch, isLoading]);
	return {
		departments,
		doctors,
		isLoading,
	};
};
