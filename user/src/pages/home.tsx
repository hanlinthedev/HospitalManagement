import {
	Departments,
	FeaturedDoctors,
	Hero,
	HowItWork,
} from "@/components/home";
import { useHome } from "@/hooks/useHome";

const Home = () => {
	const { departments, doctors } = useHome();
	return (
		<>
			<Hero />
			<HowItWork />
			<Departments departments={departments} />
			<FeaturedDoctors doctors={doctors} />
		</>
	);
};

export default Home;
