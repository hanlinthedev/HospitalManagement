import {
	Department,
	DepartmentImage,
	DepartmentTitle,
} from "@/components/departments";
import { Department as IDepartment } from "@/types";
import { ChevronRightCircle } from "lucide-react";
import { Suspense } from "react";
import { Link } from "react-router";

const Departments = ({ departments }: { departments: IDepartment[] }) => {
	return (
		<section className="p-4 sm:px-12 mb-4 sm:mb-12">
			<h1 className=" font-semibold text-2xl text-primary">Departments</h1>
			<div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-12 justify-items-center px-4">
				<Suspense fallback={<div>Loading...</div>}>
					{departments.map((department, index) => (
						<Department key={index}>
							<DepartmentImage icon={department.icon} />
							<DepartmentTitle name={department.name} />
						</Department>
					))}
				</Suspense>
				<Department>
					<Link
						to="/department"
						className="flex flex-col justify-center items-center gap-4 "
					>
						<div className="w-full flex justify-center">
							<ChevronRightCircle className="text-white w-32 h-30" />
						</div>
						<div className="text-2xl font-semibold">View All</div>
					</Link>
				</Department>
			</div>
		</section>
	);
};

export default Departments;
