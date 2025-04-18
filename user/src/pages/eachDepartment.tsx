import { useParams } from "react-router";

const EachDepartment = () => {
	const { id } = useParams();
	return (
		<div>
			<div className="w-full rounded-2xl flex pt-20 h-[594px] bg-cover bg-[url('@/assets/hero.svg')] bg-center bg-fixed bg-repeat relative  ">
				<div className="sticky top-20  bg-white/50  backdrop-blur-[3px] w-full h-[349px] px-4 lg:px-0  py-8"></div>
			</div>
		</div>
	);
};

export default EachDepartment;
