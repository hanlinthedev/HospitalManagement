import { cn } from "@/lib/utils";
import { Button } from "../ui/button";

const Department = ({ children }: { children?: React.ReactNode }) => {
    return (
        <div className="w-full max-w-xs p-8  text-white flex flex-col justify-center items-center gap-8 bg-primary-foreground rounded-2xl shadow shadow-primary-foreground">
            {children}
        </div>
    );
};

export const DepartmentImage = ({ icon }: { icon: string }) => {
    return (
        <div className="w-full flex justify-center">
            <img className="w-1/2 " src={icon} alt="" />
        </div>
    );
};

export const DepartmentTitle = ({ name }: { name: string }) => {
    return <div className="text-2xl font-semibold">{name}</div>;
};

export const DepartmentSeperator = () => {
    return <hr className="w-full bg-white text-white h-0.5 rounded-2xl" />;
};

export const DepartmentDescription = ({
    description,
}: {
    description: string;
}) => {
    return <div className="">{description}</div>;
};

export const DepartmentAction = ({
    children,
    className,
}: {
    children?: React.ReactNode;
    className?: string;
}) => {
    return (
        <div className="w-full flex justify-center">
            <Button
                variant="ghost"
                className={cn(
                    "text-white hover:text-primary font-semibold px-4 py-2 rounded-md",
                    className
                )}
            >
                {children}
            </Button>
        </div>
    );
};

export default Department;
