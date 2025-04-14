const Department = ({ children }: { children?: React.ReactNode }) => {
	return (
		<div className="w-full max-w-xs h-72 text-white flex flex-col justify-center items-center gap-8 bg-primary-foreground rounded-2xl shadow shadow-primary-foreground">
			{children}
		</div>
	);
};

export default Department;
