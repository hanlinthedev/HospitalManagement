import { Button } from "@/components/ui/button";
import { Doctor } from "@/types";

export default function DoctorCard({
	name,
	profile_picture,
	specialization,
}: Doctor) {
	return (
		<div className="w-full max-w-xs overflow-hidden rounded-xl shadow shadow-primary-foreground text-white">
			{/* Image section */}
			<div className="bg-gray-400">
				<img
					src={profile_picture}
					width={380}
					height={240}
					alt="Doctor profile"
					className="w-full object-cover"
				/>
			</div>

			{/* Info section */}
			<div className="p-4 bg-primary-foreground">
				<div className="space-y-1">
					<h3 className="text-xl font-bold text-gray-700">{name}</h3>
					<p className="text-gray-700">{specialization.name}</p>
				</div>

				<div className="flex justify-end mt-2">
					<Button
						variant="outline"
						className="bg-white text-[#d4a08f] border-none hover:bg-gray-100 hover:text-[#d4a08f] font-semibold px-6"
					>
						Book
					</Button>
				</div>
			</div>
		</div>
	);
}
