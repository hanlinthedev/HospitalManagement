import { Route, Routes, useLocation } from "react-router";
import "./App.css";
import AppLayout from "./components/common/AppLayout";

import { lazy, Suspense } from "react";
import Loading from "./components/common/Loading";
import { EachDepartment } from "./pages";

const About = lazy(() => import("./pages/about"));
const Departments = lazy(() => import("./pages/departments"));
const Doctors = lazy(() => import("./pages/doctors"));
const Home = lazy(() => import("./pages/home"));
const Login = lazy(() => import("./pages/login"));
function App() {
	const location = useLocation();
	return (
		<Routes>
			<Route path="/" element={<AppLayout />}>
				<Route
					index
					element={
						<Suspense key={location.pathname} fallback={<Loading />}>
							<Home />{" "}
						</Suspense>
					}
				/>
				<Route path="department">
					<Route
						index
						element={
							<Suspense key={location.pathname} fallback={<Loading />}>
								<Departments />
							</Suspense>
						}
					/>
					<Route path=":id" element={<EachDepartment />} />
				</Route>
				<Route
					path="doctor"
					element={
						<Suspense key={location.pathname} fallback={<Loading />}>
							<Doctors />
						</Suspense>
					}
				/>
				<Route
					path="about"
					element={
						<Suspense key={location.pathname} fallback={<Loading />}>
							{" "}
							<About />{" "}
						</Suspense>
					}
				/>
				<Route path="*" element={<div>404</div>} />
				<Route path="login" element={<Login />} />
			</Route>
		</Routes>
	);
}

export default App;
