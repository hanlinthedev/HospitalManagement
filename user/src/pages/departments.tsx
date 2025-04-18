import {
	Department,
	DepartmentAction,
	DepartmentDescription,
	DepartmentImage,
	DepartmentSeperator,
	DepartmentTitle,
} from "@/components/departments";
import { useDepartment } from "@/hooks/useDepartment";
import { ChevronsRight } from "lucide-react";
import { Link } from "react-router";

const Departments = () => {
	const { isLoading, departments } = useDepartment();
	console.log(departments, isLoading);
	return (
		<section className="p-4 sm:p-12">
			<h1 className=" font-semibold text-2xl text-primary">Departments</h1>
			<div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 justify-items-center py-4 sm:py-12">
				{departments.map((department) => (
					<Department key={department.id}>
						<DepartmentImage icon={department.icon} />
						<DepartmentTitle name={department.name} />
						<DepartmentSeperator />
						<DepartmentDescription description="fasdfa af sa a as asf asdl ae af aweof alf jasf oajs flas fjas las fjas a aflsfd jas aslj asl fjsao " />
						<DepartmentAction>
							<Link
								to={department.id.toString()}
								className="text-md gap-1 flex justify-center items-center"
							>
								View Doctors <ChevronsRight size={28} strokeWidth={3} />
							</Link>
						</DepartmentAction>
					</Department>
				))}
			</div>
		</section>
	);
};

export default Departments;
