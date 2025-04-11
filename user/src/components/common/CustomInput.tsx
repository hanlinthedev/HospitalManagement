import { ErrorMessage, Field } from "formik";
import { Input } from "../ui/input";

type Props = {
	name: string;
	placeholder: string;
	type?: string;
};

const CustomInput = ({ name, placeholder, type = "text" }: Props) => {
	return (
		<div className="flex flex-col gap-1 my-4">
			<Field type={type} name={name} placeholder={placeholder} as={Input} />
			<ErrorMessage
				name={name}
				className="text-red-400 text-sm"
				component={"span"}
			/>
		</div>
	);
};

export default CustomInput;
