import CustomForm from "@/components/common/CustomForm";
import CustomInput from "@/components/common/CustomInput";
import useAuth from "@/hooks/useAuth";

import * as yup from "yup";
const Login = () => {
	const { login } = useAuth();
	const onSubmit = (data: { email: string; password: string }) => {
		login(data);
	};
	const initialValues = {
		email: "",
		password: "",
	};
	const validationSchema = yup.object({
		email: yup.string().email().required(),
		password: yup.string().required(),
	});

	return (
		<section className="w-[100vh] h-[50vh] flex flex-col justify-center items-center mx-auto bg-amber-500">
			Login
			<CustomForm
				customCss="w-2/3"
				ctaLabel="Login"
				initialValue={initialValues}
				onSubmit={onSubmit}
				validationSchema={validationSchema}
			>
				<CustomInput name="email" placeholder="example@eg.com" type="email" />
				<CustomInput name="password" placeholder="password" type="password" />
			</CustomForm>
		</section>
	);
};

export default Login;
