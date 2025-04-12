import { NavLink } from "react-router";
import { Button } from "../ui/button";

const Header = () => {
	return (
		<nav className="flex justify-between py-4">
			<div> Logo</div>
			<div className="flex gap-4 justify-center items-center">
				<NavLink
					to="/department"
					className={({ isActive, isPending }) =>
						isPending ? "bg-red-400" : isActive ? "bg-green-500" : "bg-blue-500"
					}
				>
					Departments
				</NavLink>
				<NavLink
					to="/doctor"
					className={({ isActive, isPending }) =>
						isPending ? "bg-red-400" : isActive ? "bg-green-500" : "bg-blue-500"
					}
				>
					Doctors
				</NavLink>
				<NavLink
					to="/about"
					className={({ isActive, isPending }) =>
						isPending ? "bg-red-400" : isActive ? "bg-green-500" : "bg-blue-500"
					}
				>
					About
				</NavLink>
				<NavLink to="/login">
					<Button className="px-4"> Login</Button>
				</NavLink>
			</div>
		</nav>
	);
};

export default Header;
