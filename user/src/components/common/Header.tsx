import logo from "@/assets/logo.svg";
import { AlignRight } from "lucide-react";
import { Link, NavLink } from "react-router";
import { Button } from "../ui/button";
import {
	Sheet,
	SheetContent,
	SheetDescription,
	SheetHeader,
	SheetTitle,
	SheetTrigger,
} from "../ui/sheet";

export const NavButton = () => {
	return (
		<>
			<NavLink
				to="/department"
				className={({ isActive, isPending }) =>
					isPending
						? "text-primary/80"
						: isActive
						? "text-primary"
						: "text-gray-500"
				}
			>
				Departments
			</NavLink>
			<NavLink
				to="/doctor"
				className={({ isActive, isPending }) =>
					isPending
						? "text-primary/80"
						: isActive
						? "text-primary"
						: "text-gray-500"
				}
			>
				Doctors
			</NavLink>
			<NavLink
				to="/about"
				className={({ isActive, isPending }) =>
					isPending
						? "text-primary/80"
						: isActive
						? "text-primary"
						: "text-gray-500"
				}
			>
				About
			</NavLink>
			<NavLink to="/login">
				<Button className="px-4"> Login</Button>
			</NavLink>
		</>
	);
};
const Header = () => {
	return (
		<nav className="flex justify-between py-2 md:py-4 h-24 bg-amber-50 w-full px-4 md:px-16 sticky top-0 z-50">
			<Link to="/" className="flex justify-center items-center">
				<img src={logo} width={100} height={100} alt="Logo" />
			</Link>
			<div className="hidden md:flex gap-8 justify-center items-center font-semibold">
				<NavButton />
			</div>
			<div className="flex gap-4 md:hidden">
				<Sheet>
					<SheetTrigger>
						<AlignRight strokeWidth={3} />
					</SheetTrigger>
					<SheetContent side="left">
						<SheetHeader>
							<SheetTitle className="text-center mb-4">
								<Link to="/" className="flex justify-center items-center">
									<img src={logo} width={100} height={100} alt="Logo" />
								</Link>
							</SheetTitle>
							<SheetDescription className="flex flex-col gap-4 items-center">
								<NavButton />
							</SheetDescription>
						</SheetHeader>
					</SheetContent>
				</Sheet>
			</div>
		</nav>
	);
};

export default Header;
