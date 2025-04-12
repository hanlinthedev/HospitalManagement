import { authApi } from "@/services";
import { RootState } from "@/store";
import { setCredentials } from "@/store/slices/authSlice";
import { useMutation } from "@tanstack/react-query";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router";

export const useAuth = () => {
	const dispatch = useDispatch();
	const navigate = useNavigate();
	const auth = useSelector((state: RootState) => state.auth);

	const loginMutation = useMutation({
		mutationFn: (credentials: { email: string; password: string }) =>
			authApi.login(credentials.email, credentials.password),
		onSuccess: (data) => {
			const { accessToken, user } = data;
			console.log(data);
			localStorage.setItem("accessToken", accessToken);
			dispatch(setCredentials({ user, accessToken }));
			navigate("/");
		},
	});
	return {
		auth,
		login: loginMutation.mutate,
		isLoading: loginMutation.isPending,
	};
};

export default useAuth;
