import { DoctorCard } from "@/components/doctors";
import { Doctor as IDoctor } from "@/types";
import { UsersRound } from "lucide-react";
import { Suspense } from "react";
import { Link } from "react-router";
const FeaturedDoctors = ({ doctors }: { doctors: IDoctor[] }) => {
	return (
		<section className="p-4 sm:px-12 mb-4 sm:mb-12">
			<h1 className=" font-semibold text-2xl text-primary">Featured Doctors</h1>
			<Suspense fallback={<div>Loading...</div>}>
				<div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-12 justify-items-center px-4">
					{doctors.map((doctor, index) => (
						<DoctorCard
							key={index}
							specialization={doctor.specialization}
							name={doctor.name}
							profile_picture={doctor.profile_picture}
						/>
					))}
					<Link
						to="/doctor"
						className="flex flex-col justify-center items-center gap-4 bg-primary-foreground rounded-2xl w-full max-w-xs shadow shadow-primary-foreground"
					>
						<div>
							<UsersRound className="text-white w-32 h-30" />
						</div>
						<div className="text-2xl font-semibold text-white">View All</div>
					</Link>
				</div>
			</Suspense>
		</section>
	);
};

export default FeaturedDoctors;
