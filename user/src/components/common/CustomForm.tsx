/* eslint-disable @typescript-eslint/no-unused-vars */
import { cn } from "@/lib/utils";
import { Form, Formik, FormikValues } from "formik";
import { Button } from "../ui/button";

interface CustomFormProps<T extends FormikValues> {
	initialValue: T;
	validationSchema?: object;
	onSubmit: (values: T) => void | Promise<void>;
	children: React.ReactNode;
	ctaLabel: string;
	customCss?: string;
}
const CustomForm = <T extends FormikValues>({
	initialValue,
	validationSchema,
	onSubmit,
	children,
	ctaLabel,
	customCss,
}: CustomFormProps<T>) => {
	return (
		<Formik
			initialValues={initialValue}
			validationSchema={validationSchema}
			onSubmit={onSubmit}
		>
			<Form className={cn("", customCss)}>
				{children}
				<div className="flex justify-center items-center"></div>
				<Button type="submit">{ctaLabel}</Button>
			</Form>
		</Formik>
	);
};

export default CustomForm;
