import { Button } from "../ui/button";
import { Link } from "react-router-dom";

export const DoctorMain = ({ children }: { children?: React.ReactNode }) => {
    return (
        <div className="flex flex-row gap-[30px] min-w-[500px] h-[100px] rounded items-center">
            {children}
        </div>
    );
};

export const DoctorMainImage = ({
    profile_picture,
}: {
    profile_picture: string;
}) => {
    return (
        <div className="w-[100px] h-[100px] rounded-full object-cover bg-gray-100 border-2 [border-color:#D5957A]">
            <img className=" " src={profile_picture} alt="profile" />
        </div>
    );
};

export const DoctorMainName = ({ name }: { name: string }) => {
    return <div className="">{name}</div>;
};

export const DoctorDegree = ({ degree }: { degree: string }) => {
    return <small>{degree}</small>;
};

export const DoctorFromWhereDepartment = ({
    specialization,
}: {
    specialization: { name: string };
}) => {
    return <small>{specialization.name}</small>;
};

export const ActionByUserToBook = () => {
    return (
        <div className="w-0.5/3 flex justify-end">
            <Button
                variant="outline"
                className="font-bold justify-end bg-[#D5957A]"
                asChild
            >
                <Link
                    to="/book page"
                    className="text-gray-500  hover:underline"
                >
                    Book
                </Link>
            </Button>
        </div>
    );
};
