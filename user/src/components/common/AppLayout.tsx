import { Outlet } from "react-router";
import Footer from "./Footer";
import Header from "./Header";

const AppLayout = () => {
	return (
		<main>
			<Header />
			<Outlet />
			<Footer />
		</main>
	);
};

export default AppLayout;
