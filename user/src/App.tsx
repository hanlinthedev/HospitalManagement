import { Route, Routes } from "react-router";
import "./App.css";
import AppLayout from "./components/common/AppLayout";
import { About, Departments, Doctors, Home, Login } from "./pages";

function App() {
	return (
		<Routes>
			<Route path="/" element={<AppLayout />}>
				<Route index element={<Home />} />
				<Route path="department" element={<Departments />} />
				<Route path="doctor" element={<Doctors />} />
				<Route path="about" element={<About />} />
				<Route path="*" element={<div>404</div>} />
				<Route path="login" element={<Login />} />
			</Route>
		</Routes>
	);
}

export default App;
