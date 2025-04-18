import { Button } from "@/components/ui/button";

export default function DoctorCard({
	children,
}: {
	children: React.ReactNode;
}) {
	return (
		<div className="w-full max-w-xs overflow-hidden rounded-xl shadow shadow-primary-foreground text-white">
			{children}
		</div>
	);
}

export const DoctorImage = ({
	profile_picture,
}: {
	profile_picture: string;
}) => {
	return (
		<div className="bg-gray-400">
			<img
				src={profile_picture}
				width={380}
				height={240}
				alt="Doctor profile"
				className="w-full object-cover"
			/>
		</div>
	);
};

export const DoctorBody = ({ children }: { children: React.ReactNode }) => {
	return <div className="p-4 bg-primary-foreground">{children}</div>;
};

export const DoctorInfo = ({ children }: { children: React.ReactNode }) => {
	return <div className="space-y-1">{children}</div>;
};

export const DoctorName = ({ name }: { name: string }) => {
	return <h3 className="text-xl font-bold text-gray-700">{name}</h3>;
};

export const DoctorSpecialization = ({
	specialization,
}: {
	specialization: string;
}) => {
	return <p className="text-gray-700">{specialization}</p>;
};

export const DoctorAction = () => {
	return (
		<div className="flex justify-end mt-2">
			<Button
				variant="outline"
				className="bg-white text-[#d4a08f] border-none hover:bg-gray-100 hover:text-[#d4a08f] font-semibold px-6"
			>
				Book
			</Button>
		</div>
	);
};
