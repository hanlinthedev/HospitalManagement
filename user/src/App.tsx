import { Route, Routes } from "react-router";
import "./App.css";
import AppLayout from "./components/common/AppLayout";
import Home from "./pages/home";

function App() {
	return (
		<Routes>
			<Route path="/" element={<AppLayout />}>
				<Route index element={<Home />} />
			</Route>
		</Routes>
	);
}

export default App;
