import { useRouteError } from "react-router";

const Error = () => {
	const error = useRouteError();
	console.log(error);
	return <div>Error</div>;
};

export default Error;
