USE [master]
GO
/****** Object:  Database [HRMS_SAG_REPLICA]    Script Date: Saturday, 11-Mar-2023 11:58:21 AM ******/
CREATE DATABASE [HRMS_SAG_REPLICA]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'HRMS_SAG', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\HRMS_SAG_REPLICA.mdf' , SIZE = 73728KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'HRMS_SAG_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\HRMS_SAG_REPLICA_log.ldf' , SIZE = 270336KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
 WITH CATALOG_COLLATION = DATABASE_DEFAULT
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET COMPATIBILITY_LEVEL = 150
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [HRMS_SAG_REPLICA].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET ARITHABORT OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET  DISABLE_BROKER 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET RECOVERY FULL 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET  MULTI_USER 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET DB_CHAINING OFF 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET ACCELERATED_DATABASE_RECOVERY = OFF  
GO
EXEC sys.sp_db_vardecimal_storage_format N'HRMS_SAG_REPLICA', N'ON'
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET QUERY_STORE = OFF
GO
USE [HRMS_SAG_REPLICA]
GO
/****** Object:  User [test]    Script Date: Saturday, 11-Mar-2023 11:58:22 AM ******/
CREATE USER [test] FOR LOGIN [test] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  User [SASystems]    Script Date: Saturday, 11-Mar-2023 11:58:22 AM ******/
CREATE USER [SASystems] WITHOUT LOGIN WITH DEFAULT_SCHEMA=[dbo]
GO
ALTER ROLE [db_datareader] ADD MEMBER [SASystems]
GO
/****** Object:  Table [dbo].[ArrearsOfFinalSettlementsNovember2022]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ArrearsOfFinalSettlementsNovember2022](
	[ArrearsID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeID] [int] NULL,
	[SessionName] [varchar](100) NULL,
	[ArrearDate] [varchar](20) NULL,
	[ArrearsAmount] [int] NULL,
	[Descriptions] [varchar](max) NULL,
	[Status] [varchar](20) NULL,
	[ApprovedBy] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[DeletedBy] [varchar](50) NULL,
	[DeletedOn] [varchar](50) NULL,
	[IsDeleted] [varchar](50) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Att_Permission]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Att_Permission](
	[AttPermissionID] [int] IDENTITY(1,1) NOT NULL,
	[SubEmpID] [int] NULL,
	[ChiefEmpID] [int] NULL,
	[IsManager] [bit] NULL,
	[IsMandatory] [bit] NULL,
	[CreatedBy] [varchar](50) NULL,
	[createdOn] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](20) NULL,
	[CompanyID] [varchar](255) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[AttData]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AttData](
	[AttDataID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[RosterID] [varchar](50) NULL,
	[EmpID] [int] NULL,
	[ATTDate] [date] NULL,
	[CheckIN] [time](7) NULL,
	[CheckOut] [time](7) NULL,
	[CheckInBy] [varchar](50) NULL,
	[CheckOutBy] [varchar](50) NULL,
	[AttStatus] [varchar](2) NULL,
	[late] [int] NULL,
	[Location] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](30) NULL,
	[IsDeleted] [bit] NULL,
	[GracePeriod] [int] NULL,
	[Overtime] [int] NULL,
	[OpeningTime] [varchar](10) NULL,
	[ClosingTime] [varchar](10) NULL,
	[EmpCode] [varchar](50) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[AttDatas]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AttDatas](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[Emp_Code] [nvarchar](max) NULL,
	[First_Name] [nvarchar](max) NULL,
	[Last_Name] [nvarchar](max) NULL,
	[Department] [nvarchar](max) NULL,
	[Punch_Time] [nvarchar](max) NULL,
	[Punch_State] [nvarchar](max) NULL,
	[Punch_State_Display] [nvarchar](max) NULL,
	[Verify_Type] [int] NOT NULL,
	[Verify_Type_Display] [nvarchar](max) NULL,
	[Work_Code] [nvarchar](max) NULL,
	[Area_Alias] [nvarchar](max) NULL,
	[Terminal_Sn] [nvarchar](max) NULL,
	[Temperature] [float] NOT NULL,
	[Terminal_Alias] [nvarchar](max) NULL,
	[Upload_Time] [nvarchar](max) NULL,
 CONSTRAINT [PK_dbo.AttDatas] PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Candidate_Detail]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Candidate_Detail](
	[CandID] [int] IDENTITY(1,1) NOT NULL,
	[CandName] [varchar](30) NULL,
	[FatherHusband] [varchar](30) NULL,
	[Mobile] [varchar](20) NULL,
	[Email] [varchar](50) NULL,
	[ExpectedSalary] [varchar](8) NULL,
	[Photo] [varchar](250) NULL,
	[CandAddress] [varchar](250) NULL,
	[Curr_Salary] [money] NULL,
	[Curr_Designation] [varchar](50) NULL,
	[Qualification] [varchar](max) NULL,
	[Skill] [varchar](max) NULL,
	[experience] [varchar](255) NULL,
	[Rating] [varchar](10) NULL,
	[CreatedBy] [varchar](30) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](30) NULL,
	[UpdatedOn] [varchar](15) NULL,
	[CompanyID] [nvarchar](max) NULL,
	[stats] [varchar](50) NULL,
	[JobID] [int] NULL,
 CONSTRAINT [PK__Candidat__98327DE3821B0DD5] PRIMARY KEY CLUSTERED 
(
	[CandID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[cities]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cities](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[city_name] [varchar](max) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[degree_programs]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[degree_programs](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[program_name] [varchar](max) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[degree_types]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[degree_types](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[type_name] [varchar](100) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Emp_Documents]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Emp_Documents](
	[DocumentID] [int] IDENTITY(1,1) NOT NULL,
	[EmployeeID] [int] NULL,
	[CompanyID] [varchar](255) NULL,
	[Image1] [varchar](255) NULL,
	[Image2] [varchar](255) NULL,
	[Image3] [varchar](255) NULL,
	[Image4] [varchar](255) NULL,
	[Image5] [varchar](255) NULL,
	[Image6] [varchar](255) NULL,
PRIMARY KEY CLUSTERED 
(
	[DocumentID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Emp_Profile]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Emp_Profile](
	[EmployeeID] [int] IDENTITY(1,1) NOT NULL,
	[Name] [varchar](50) NULL,
	[FatherHusband] [varchar](50) NULL,
	[Gender] [varchar](6) NULL,
	[Religion] [varchar](10) NULL,
	[Email] [varchar](30) NULL,
	[Mobile] [varchar](20) NULL,
	[Phone] [varchar](20) NULL,
	[CNIC] [varchar](20) NULL,
	[CnicExpiry] [varchar](50) NULL,
	[MaritalStatus] [varchar](10) NULL,
	[DOB] [varchar](50) NULL,
	[BloodGroup] [varchar](4) NULL,
	[Address] [varchar](500) NULL,
	[City] [varchar](20) NULL,
	[Photo] [varchar](300) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[DeletedBy] [varchar](50) NULL,
	[DeletedOn] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[CompanyID] [varchar](255) NULL,
	[Relation] [varchar](50) NULL,
	[Employee_Code] [varchar](50) NULL,
	[CompanyName] [varchar](100) NULL,
 CONSTRAINT [PK_Emp_Profile] PRIMARY KEY CLUSTERED 
(
	[EmployeeID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Emp_Register]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Emp_Register](
	[RegisterID] [int] IDENTITY(1,1) NOT NULL,
	[EmployeeID] [int] NULL,
	[EmployeeCode] [varchar](10) NULL,
	[CompanyID] [varchar](50) NULL,
	[Department] [varchar](100) NULL,
	[Designation] [varchar](100) NULL,
	[PostingCity] [varchar](20) NULL,
	[CompanyEmail] [varchar](50) NULL,
	[JoiningDate] [varchar](50) NULL,
	[Status] [varchar](15) NULL,
	[ReportingTo] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[DeletedBy] [varchar](50) NULL,
	[DeletedOn] [datetime] NULL,
	[ReportingTo2] [varchar](50) NULL,
	[JobShift] [varchar](100) NULL,
	[Salary] [int] NULL,
	[Stipend] [int] NULL,
	[JobStatus] [varchar](20) NULL,
	[ProbationEnd] [varchar](20) NULL,
	[JobDescription] [text] NULL,
	[ChildCompany] [int] NULL,
	[SendNotification] [varchar](20) NULL,
	[AllowEmployeesAttendance] [varchar](10) NULL,
	[EportalAccess] [varchar](10) NULL,
	[ExpStatus] [varchar](5) NULL,
	[EduStatus] [varchar](5) NULL,
	[DocStatus] [varchar](10) NULL,
	[RegDate] [varchar](50) NULL,
	[MethodType] [varchar](50) NULL,
	[BankAccount] [varchar](50) NULL,
	[bank_name] [varchar](100) NULL,
	[account_name] [varchar](100) NULL,
	[remarks] [varchar](max) NULL,
	[CompanyName] [varchar](100) NULL,
	[SuspensionEnd] [varchar](50) NULL,
	[AllowAttendance] [varchar](10) NULL,
	[ResignDate] [varchar](50) NULL,
	[TerminateDate] [varchar](50) NULL,
 CONSTRAINT [PK_Emp_Register] PRIMARY KEY CLUSTERED 
(
	[RegisterID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Emp_Work_Experience]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Emp_Work_Experience](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[EmployeeID] [int] NULL,
	[CompanyID] [varchar](20) NULL,
	[JobTitle] [varchar](50) NULL,
	[CompanyName] [varchar](50) NULL,
	[StartingDate] [varchar](25) NULL,
	[LeavingDate] [varchar](25) NULL,
	[Refrence] [varchar](30) NULL,
	[CreatedBy] [varchar](30) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](30) NULL,
	[UpdatedOn] [varchar](20) NULL,
 CONSTRAINT [PK__Emp_Work__3213E83FD9EB2B42] PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[EmpGraceHours]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[EmpGraceHours](
	[EmpGraceID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](255) NULL,
	[EmployeeID] [int] NULL,
	[TotalGP] [int] NULL,
	[UsedGP] [int] NULL,
	[IsDeleted] [bit] NULL,
	[CreatedBy] [varchar](20) NULL,
	[CreatedOn] [varchar](20) NULL,
	[UpdatedBy] [varchar](20) NULL,
	[UpdatedOn] [varchar](20) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[EmpLeave]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[EmpLeave](
	[LeaveID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](30) NULL,
	[EmployeeID] [int] NULL,
	[LeaveType] [varchar](20) NULL,
	[TotalLeave] [int] NULL,
	[RemainingLeave] [int] NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](30) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](30) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Employee_Dep_Comp]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Employee_Dep_Comp](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](100) NULL,
	[Department] [varchar](100) NULL,
	[Company] [varchar](100) NULL,
	[Status] [varchar](50) NULL,
	[CreatedBy] [varchar](100) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](100) NULL,
	[UpdatedOn] [datetime] NULL,
	[IsDeleted] [bit] NULL,
	[DeletedBy] [varchar](100) NULL,
	[DeletedOn] [varchar](50) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Employee_Qualification]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Employee_Qualification](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[EmployeeID] [int] NULL,
	[DegreeType] [varchar](100) NULL,
	[DegreeName] [varchar](100) NULL,
	[InstituteName] [varchar](100) NULL,
	[PassingYear] [varchar](30) NULL,
	[CreatedBy] [varchar](30) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](30) NULL,
	[UpdatedOn] [varchar](30) NULL,
	[CompanyID] [varchar](255) NULL,
 CONSTRAINT [PK__Employee__3213E83F7F979DBD] PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[event]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[event](
	[id] [nchar](10) NULL,
	[title] [nchar](10) NULL,
	[start] [nchar](10) NULL,
	[end] [nchar](10) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[events]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[events](
	[event_id] [int] IDENTITY(1,1) NOT NULL,
	[title] [varchar](250) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [datetime] NULL,
	[CompanyID] [varchar](50) NULL,
	[start] [varchar](30) NULL,
	[end] [varchar](30) NULL,
	[share_with] [varchar](30) NULL,
	[location] [varchar](max) NULL,
	[description] [varchar](max) NULL,
	[url] [varchar](max) NULL,
	[start_time] [varchar](20) NULL,
	[end_time] [varchar](20) NULL,
 CONSTRAINT [PK_events] PRIMARY KEY CLUSTERED 
(
	[event_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[FinalSettlement]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[FinalSettlement](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](255) NULL,
	[EmployeeID] [int] NULL,
	[SessionName] [varchar](255) NULL,
	[ResignOn] [varchar](50) NULL,
	[LoanAmount] [money] NULL,
	[Fine] [money] NULL,
	[DuesAmount] [money] NULL,
	[ArrearsAmount] [money] NULL,
	[BonusAmount] [money] NULL,
	[AllowanceAmount] [money] NULL,
	[SettlementAmount] [money] NULL,
	[Gratuity] [money] NULL,
	[PayableSalary] [money] NULL,
	[DStatus] [varchar](10) NULL,
	[MStatus] [varchar](10) NULL,
	[HrStatus] [varchar](50) NULL,
	[Status] [varchar](50) NULL,
	[FStatus] [varchar](50) NULL,
	[Remarks] [varchar](250) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[IsDeleted] [varchar](50) NULL,
	[DeletedBy] [varchar](50) NULL,
	[DeletedOn] [varchar](50) NULL,
	[PVID] [varchar](200) NULL,
	[ReceivedBy] [varchar](255) NULL,
	[ReceivedTime] [varchar](50) NULL,
	[ReceivedThrough] [varchar](255) NULL,
	[CashAmount] [int] NULL,
	[BankAmount] [int] NULL,
	[CashID] [bigint] NULL,
	[BankID] [bigint] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[FineDetail]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[FineDetail](
	[FineId] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeID] [int] NULL,
	[FineSession] [varchar](100) NULL,
	[FineAmount] [int] NULL,
	[FineDate] [varchar](30) NULL,
	[Remarks] [varchar](max) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Status] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[FineId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Fuel_Management]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Fuel_Management](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeID] [varchar](10) NULL,
	[AllowedAmount] [int] NULL,
	[EccessAmount] [int] NULL,
	[FuelUnit] [varchar](50) NULL,
	[FuelUnitPrice] [money] NULL,
	[Session] [varchar](max) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
 CONSTRAINT [FuelManagement] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[FuelAllowance]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[FuelAllowance](
	[AllowanceID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeID] [varchar](10) NULL,
	[FuelType] [varchar](250) NULL,
	[FuelQuantity] [decimal](5, 2) NULL,
	[FuelUnit] [varchar](50) NULL,
	[Descriptions] [varchar](max) NULL,
	[Status] [varchar](50) NULL,
	[ApprovedBy] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
 CONSTRAINT [PayrollFuelAllowance] PRIMARY KEY CLUSTERED 
(
	[AllowanceID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[FuelBill]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[FuelBill](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeID] [varchar](10) NULL,
	[FuelType] [varchar](250) NULL,
	[FuelQuantity] [decimal](5, 2) NULL,
	[BillAmount] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[Description] [varchar](max) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
 CONSTRAINT [FuelBills] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Holiday]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Holiday](
	[HolidayID] [int] IDENTITY(1,1) NOT NULL,
	[HolidayName] [varchar](50) NULL,
	[holidaystartDate] [varchar](50) NULL,
	[HolidayEndDate] [varchar](50) NULL,
	[HolidayDescription] [varchar](50) NULL,
	[NoOfDays] [int] NULL,
	[IsDeleted] [bit] NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](20) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](20) NULL,
	[CompanyID] [varchar](50) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[HR_Comp_Dept_Desig]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[HR_Comp_Dept_Desig](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyName] [varchar](100) NULL,
	[DepartmentName] [varchar](100) NULL,
	[DesignationName] [varchar](100) NULL,
 CONSTRAINT [PK_HR_Comp_Dept_Desig] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[HrCompanyConfig]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[HrCompanyConfig](
	[ConfigId] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[GratutyStart] [varchar](10) NULL,
	[MaxLoan] [varchar](10) NULL,
	[AnnualLeaves] [int] NULL,
	[SickLeaves] [int] NULL,
	[CasualLeaves] [int] NULL,
	[MinutesDeduction] [int] NULL,
	[MaxInstallment] [int] NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[ConfigId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[HrSessions]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[HrSessions](
	[SessionID] [int] IDENTITY(1,1) NOT NULL,
	[SessionName] [varchar](255) NULL,
	[StartDate] [varchar](255) NULL,
	[EndDate] [varchar](255) NULL,
	[CreateBy] [varchar](50) NULL,
	[CreateOn] [varchar](50) NULL,
	[CompanyID] [varchar](50) NULL,
	[CurrentSession] [varchar](10) NULL,
	[AttClosedPayrollStart] [varchar](10) NULL,
	[DistState] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[SessionID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[interview_detail]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[interview_detail](
	[CompanyID] [nvarchar](max) NULL,
	[InterviewerName] [varchar](20) NULL,
	[InterviewLocation] [varchar](50) NULL,
	[rating] [varchar](20) NULL,
	[Remarks] [varchar](50) NULL,
	[StartTime] [varchar](20) NULL,
	[EndTime] [varchar](20) NULL,
	[DayDate] [date] NULL,
	[Duration] [varchar](20) NULL,
	[InterviewID] [int] IDENTITY(1,1) NOT NULL,
	[CandID] [int] NULL,
	[onlineLink] [varchar](max) NULL,
	[firstInterviewstatus] [varchar](max) NULL,
	[secondInterviewstatus] [varchar](max) NULL,
	[finalInterviewstatus] [varchar](max) NULL,
	[finalInterviewComments] [varchar](max) NULL,
	[secondInterviewComments] [varchar](max) NULL,
	[firstInterviewComments] [varchar](max) NULL,
	[hire_sts] [varchar](20) NULL,
	[updatedOn] [varchar](50) NULL,
 CONSTRAINT [PK_interview_detail] PRIMARY KEY CLUSTERED 
(
	[InterviewID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[leave_Requisition]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[leave_Requisition](
	[LeaveRQID] [int] IDENTITY(1,1) NOT NULL,
	[EmployeeID] [int] NULL,
	[Leavetype] [varchar](20) NULL,
	[LeaveDescription] [varchar](max) NULL,
	[StartDate] [date] NULL,
	[EndDate] [date] NULL,
	[NoOfDays] [int] NULL,
	[Reason] [varchar](max) NULL,
	[AppliedBy] [varchar](50) NULL,
	[HRApproval] [varchar](50) NULL,
	[ManagerApproval] [varchar](50) NULL,
	[HRRemarks] [varchar](500) NULL,
	[ManagerRemarks] [varchar](255) NULL,
	[PendingLeaveStatus] [varchar](10) NULL,
	[CompanyID] [varchar](50) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[leaves]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[leaves](
	[LeaveID] [int] IDENTITY(1,1) NOT NULL,
	[LeaveType] [varchar](20) NULL,
	[leaveDetail] [varchar](max) NULL,
	[IsDeleted] [bit] NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](20) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](20) NULL,
	[CompanyID] [varchar](20) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[LoanDetail]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[LoanDetail](
	[DetailId] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeID] [int] NULL,
	[LoanId] [int] NULL,
	[InstallmentNo] [int] NULL,
	[InstallmentSession] [varchar](100) NULL,
	[InstallmentAmount] [int] NULL,
	[InstallmentDate] [varchar](30) NULL,
	[InstallmentStatus] [varchar](50) NULL,
	[PaidThrough] [varchar](20) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[LoanType] [varchar](50) NULL,
	[Remarks] [varchar](500) NULL,
	[DeletedBy] [varchar](50) NULL,
	[DeletedOn] [varchar](50) NULL,
	[IsDeleted] [varchar](50) NULL,
 CONSTRAINT [PK__LoanDeta__135C316DE59D7C8D] PRIMARY KEY CLUSTERED 
(
	[DetailId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[LoanDetails161]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[LoanDetails161](
	[Id] [bigint] NOT NULL,
	[Loan_Amt] [numeric](16, 2) NULL,
	[Date] [datetime] NULL,
	[Status] [nvarchar](max) NULL,
	[Loan_Id] [bigint] NULL,
	[Paid_Amt] [numeric](16, 2) NULL,
	[Emp_Id] [bigint] NULL,
	[IsWaivedOff] [bit] NULL,
	[Reason] [nvarchar](500) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[LoanRequisition]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[LoanRequisition](
	[LoanId] [int] IDENTITY(22694,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeID] [int] NULL,
	[LoanType] [varchar](30) NULL,
	[LoanAmount] [money] NULL,
	[LoanReason] [varchar](500) NULL,
	[LoanInstallments] [int] NULL,
	[LoanSession] [varchar](100) NULL,
	[ApplyDate] [varchar](100) NULL,
	[ReceivedDate] [varchar](100) NULL,
	[ReceivedBy] [varchar](100) NULL,
	[ManagerApproval] [varchar](20) NULL,
	[HrApproval] [varchar](20) NULL,
	[ReqStatus] [varchar](20) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[DeletedBy] [varchar](50) NULL,
	[DeletedOn] [varchar](50) NULL,
	[IsDeleted] [varchar](50) NULL,
	[PVID] [varchar](50) NULL,
 CONSTRAINT [PK_LoanRequisition] PRIMARY KEY CLUSTERED 
(
	[LoanId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Loans161]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Loans161](
	[LoanReqID] [bigint] NOT NULL,
	[EmployeeID] [int] NULL,
	[EmpName] [nvarchar](max) NULL,
	[Amount] [numeric](16, 2) NULL,
	[Reason] [nvarchar](max) NULL,
	[Installments] [int] NULL,
	[CreatedAt] [datetime] NULL,
	[CreatedBy] [nvarchar](500) NULL,
	[HrRemarks] [nvarchar](max) NULL,
	[ManagerRemarks] [nvarchar](max) NULL,
	[LoanType] [nvarchar](50) NULL,
	[Manager_Name] [nvarchar](500) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Payroll_Distribution]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Payroll_Distribution](
	[DistributionID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](255) NULL,
	[EmployeeID] [int] NULL,
	[Name] [varchar](50) NULL,
	[EmpCode] [varchar](10) NULL,
	[Department] [varchar](100) NULL,
	[Designation] [varchar](100) NULL,
	[PostingCity] [varchar](20) NULL,
	[SessionName] [varchar](255) NULL,
	[Mobile] [varchar](20) NULL,
	[CNIC] [varchar](20) NULL,
	[Address] [varchar](500) NULL,
	[Photo] [varchar](255) NULL,
	[MethodType] [varchar](50) NULL,
	[BankAcc] [varchar](50) NULL,
	[BankName] [varchar](100) NULL,
	[AccountName] [varchar](100) NULL,
	[FinanceApprovalID] [int] NULL,
	[Salary] [int] NULL,
	[OAmount] [int] NULL,
	[DAmount] [int] NULL,
	[TAmount] [int] NULL,
	[InstallmentNo] [varchar](50) NULL,
	[InstallmentAmount] [int] NULL,
	[Fine] [int] NULL,
	[DuesAmount] [int] NULL,
	[ArrearsAmount] [int] NULL,
	[BonusAmount] [int] NULL,
	[AllowanceAmount] [int] NULL,
	[PayableSalary] [int] NULL,
	[DStatus] [varchar](10) NULL,
	[HrStatus] [varchar](50) NULL,
	[FStatus] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[ReceivedThrough] [varchar](255) NULL,
	[ReceivedTime] [datetime] NULL,
	[AdvanceAmount] [int] NULL,
	[FuelAmount] [int] NULL,
	[FuelReceivable] [int] NULL,
	[TaxAmount] [int] NULL,
	[StipendAmount] [int] NULL,
	[CompanyName] [varchar](100) NULL,
	[BankPayable] [int] NULL,
	[CashPayable] [int] NULL,
	[CashAmount] [int] NULL,
	[BankAmount] [int] NULL,
	[CashID] [bigint] NULL,
	[BankID] [bigint] NULL,
	[PVID] [varchar](50) NULL,
	[RemainingAmount] [int] NULL,
	[PaidAmount] [int] NULL,
	[SalaryStatus] [varchar](150) NULL,
	[PNO] [int] NULL,
	[CurrentCashPaid] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Payroll_SalaryNOTMatched]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Payroll_SalaryNOTMatched](
	[DistributionID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](255) NULL,
	[EmployeeID] [int] NULL,
	[Name] [varchar](50) NULL,
	[EmpCode] [varchar](10) NULL,
	[Department] [varchar](100) NULL,
	[Designation] [varchar](100) NULL,
	[PostingCity] [varchar](20) NULL,
	[SessionName] [varchar](255) NULL,
	[Mobile] [varchar](20) NULL,
	[CNIC] [varchar](20) NULL,
	[Address] [varchar](500) NULL,
	[Photo] [varchar](255) NULL,
	[MethodType] [varchar](50) NULL,
	[BankAcc] [varchar](50) NULL,
	[BankName] [varchar](100) NULL,
	[AccountName] [varchar](100) NULL,
	[FinanceApprovalID] [int] NULL,
	[Salary] [int] NULL,
	[OAmount] [int] NULL,
	[DAmount] [int] NULL,
	[TAmount] [int] NULL,
	[InstallmentNo] [varchar](50) NULL,
	[InstallmentAmount] [int] NULL,
	[Fine] [int] NULL,
	[DuesAmount] [int] NULL,
	[ArrearsAmount] [int] NULL,
	[BonusAmount] [int] NULL,
	[AllowanceAmount] [int] NULL,
	[PayableSalary] [int] NULL,
	[DStatus] [varchar](10) NULL,
	[HrStatus] [varchar](50) NULL,
	[FStatus] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[ReceivedThrough] [varchar](255) NULL,
	[ReceivedTime] [datetime] NULL,
	[AdvanceAmount] [int] NULL,
	[FuelAmount] [int] NULL,
	[FuelReceivable] [int] NULL,
	[TaxAmount] [int] NULL,
	[StipendAmount] [int] NULL,
	[CompanyName] [varchar](100) NULL,
	[BankPayable] [int] NULL,
	[CashPayable] [int] NULL,
	[CashAmount] [int] NULL,
	[BankAmount] [int] NULL,
	[CashID] [bigint] NULL,
	[BankID] [bigint] NULL,
	[PVID] [varchar](50) NULL,
	[RemainingAmount] [int] NULL,
	[PaidAmount] [int] NULL,
	[SalaryStatus] [varchar](150) NULL,
	[PNO] [int] NULL,
	[CurrentCashPaid] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PayrollAllowance]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PayrollAllowance](
	[AllowanceID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeID] [varchar](10) NULL,
	[StartSession] [varchar](100) NULL,
	[SessionEndDate] [varchar](100) NULL,
	[ApplyDate] [varchar](50) NULL,
	[AllowanceType] [varchar](50) NULL,
	[AllowanceAmount] [int] NULL,
	[Descriptions] [varchar](max) NULL,
	[Status] [varchar](50) NULL,
	[ApprovedBy] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[AllowanceID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PayrollArrears]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PayrollArrears](
	[ArrearsID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeID] [int] NULL,
	[SessionName] [varchar](100) NULL,
	[ArrearDate] [varchar](20) NULL,
	[ArrearsAmount] [int] NULL,
	[Descriptions] [varchar](max) NULL,
	[Status] [varchar](20) NULL,
	[ApprovedBy] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[DeletedBy] [varchar](50) NULL,
	[DeletedOn] [varchar](50) NULL,
	[IsDeleted] [varchar](50) NULL,
 CONSTRAINT [PK__PayrollA__52EE19EA0AC4BAB1] PRIMARY KEY CLUSTERED 
(
	[ArrearsID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PayrollBonuses]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PayrollBonuses](
	[BonusID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeID] [varchar](10) NULL,
	[SessionName] [varchar](100) NULL,
	[BonusDate] [varchar](50) NULL,
	[BonusAmount] [int] NULL,
	[Descriptions] [varchar](max) NULL,
	[Status] [varchar](50) NULL,
	[ApprovedBy] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
 CONSTRAINT [PK__PayrollB__8E5547086CFC3FE7] PRIMARY KEY CLUSTERED 
(
	[BonusID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PayrollDues]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PayrollDues](
	[DuesID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeID] [varchar](10) NULL,
	[SessionName] [varchar](100) NULL,
	[DuesType] [varchar](50) NULL,
	[DuesDate] [varchar](50) NULL,
	[DuesAmount] [int] NULL,
	[Descriptions] [varchar](max) NULL,
	[Status] [varchar](50) NULL,
	[ApprovedBy] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
 CONSTRAINT [PK__PayrollD__A9BB1D6EE4163085] PRIMARY KEY CLUSTERED 
(
	[DuesID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PayrollEmployeesDetail]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PayrollEmployeesDetail](
	[EmpDetID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeID] [int] NULL,
	[UpdatedSalary] [money] NULL,
	[UpdatedPerDay] [int] NULL,
	[UpdatedPerHours] [int] NULL,
	[UpdatedDate] [varchar](50) NULL,
	[Statusd] [varchar](1) NULL,
	[Remarks] [varchar](500) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](20) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](20) NULL,
	[LastIncrement] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[EmpDetID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PayrollFinanceApproval]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PayrollFinanceApproval](
	[FinanceApprovalID] [int] IDENTITY(1,1) NOT NULL,
	[EmployeeID] [int] NULL,
	[CompanyID] [varchar](50) NULL,
	[SessionName] [varchar](255) NULL,
	[Salary] [int] NULL,
	[OAmount] [int] NULL,
	[DAmount] [int] NULL,
	[TAmount] [int] NULL,
	[InstallmentNo] [varchar](50) NULL,
	[InstallmentAmount] [int] NULL,
	[Fine] [int] NULL,
	[DuesType] [varchar](50) NULL,
	[DuesAmount] [int] NULL,
	[ArrearsAmount] [int] NULL,
	[ArrearsDes] [varchar](max) NULL,
	[BonusAmount] [int] NULL,
	[AllowanceType] [varchar](50) NULL,
	[AllowanceAmount] [int] NULL,
	[PayableSalary] [int] NULL,
	[DStatus] [varchar](10) NULL,
	[HrStatus] [varchar](50) NULL,
	[FStatus] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[AdvanceAmount] [int] NULL,
	[FuelAmount] [int] NULL,
	[FuelReceivable] [int] NULL,
	[TaxAmount] [int] NULL,
	[StipendAmount] [int] NULL,
	[BankPayable] [int] NULL,
	[CashPayable] [int] NULL,
 CONSTRAINT [PK__PayrollF__2A6AD3BC04FF91A0] PRIMARY KEY CLUSTERED 
(
	[FinanceApprovalID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PayrollHrApproval]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PayrollHrApproval](
	[ApprovalID] [int] IDENTITY(1,1) NOT NULL,
	[EmployeeID] [int] NULL,
	[CompanyID] [varchar](255) NULL,
	[SessionName] [varchar](50) NULL,
	[OverTime] [int] NULL,
	[Deduction] [float] NULL,
	[Salary] [int] NULL,
	[OAmount] [int] NULL,
	[DAmount] [float] NULL,
	[TAmount] [int] NULL,
	[DStatus] [varchar](50) NULL,
	[HrStatus] [varchar](10) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Stipend] [int] NULL,
 CONSTRAINT [PK__PayrollH__328477D44C358543] PRIMARY KEY CLUSTERED 
(
	[ApprovalID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PayrollTax]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PayrollTax](
	[TaxID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeID] [varchar](10) NULL,
	[StartSession] [varchar](100) NULL,
	[SessionEndDate] [varchar](100) NULL,
	[ApplyDate] [varchar](50) NULL,
	[TaxType] [varchar](50) NULL,
	[TaxAmount] [int] NULL,
	[Descriptions] [varchar](max) NULL,
	[ApprovedBy] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[TaxID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PayrollWelfareAllowance]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PayrollWelfareAllowance](
	[AllowanceID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeID] [varchar](10) NULL,
	[Session] [varchar](100) NULL,
	[ApplyDate] [varchar](50) NULL,
	[AllowanceType] [varchar](50) NULL,
	[AllowanceAmount] [int] NULL,
	[Descriptions] [varchar](max) NULL,
	[PaidThrough] [varchar](50) NULL,
	[PaidDate] [varchar](50) NULL,
	[Status] [varchar](50) NULL,
	[ApprovedBy] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[PVID] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[AllowanceID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Post_Job]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Post_Job](
	[JobID] [int] IDENTITY(1,1) NOT NULL,
	[Department] [varchar](50) NULL,
	[PostTitle] [varchar](50) NULL,
	[JobNumber] [int] NULL,
	[JobDetail] [varchar](max) NULL,
	[Education] [varchar](max) NULL,
	[Experience] [varchar](max) NULL,
	[StartDate] [date] NULL,
	[EndDate] [date] NULL,
	[Duties] [varchar](max) NULL,
	[Skill] [varchar](max) NULL,
	[Address] [varchar](100) NULL,
	[CoverPhoto] [varchar](255) NULL,
	[CreatedBy] [varchar](30) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](30) NULL,
	[UpdatedOn] [varchar](20) NULL,
	[CompanyID] [nvarchar](max) NULL,
 CONSTRAINT [PK__Post_Job__056690E239DFEB19] PRIMARY KEY CLUSTERED 
(
	[JobID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Roasters]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Roasters](
	[RosterName] [varchar](100) NULL,
	[Mon] [varchar](20) NULL,
	[Tue] [varchar](20) NULL,
	[Wed] [varchar](20) NULL,
	[Thu] [varchar](20) NULL,
	[Fri] [varchar](20) NULL,
	[Sat] [varchar](20) NULL,
	[Sun] [varchar](20) NULL,
	[CreatedBy] [varchar](30) NULL,
	[CreatedOn] [datetime] NOT NULL,
	[IsDeleted] [bit] NULL,
	[DeletedBy] [varchar](30) NULL,
	[DeletedOn] [datetime] NULL,
	[CompanyID] [varchar](50) NULL,
	[RosterID] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[SessionReport]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[SessionReport](
	[SessionReportID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeID] [int] NULL,
	[EmployeeCode] [varchar](50) NULL,
	[Name] [varchar](100) NULL,
	[Designation] [varchar](50) NULL,
	[Department] [varchar](50) NULL,
	[Totaldays] [int] NULL,
	[TotalPeresnt] [int] NULL,
	[TotalAbsent] [int] NULL,
	[TotalLeave] [int] NULL,
	[GracePeriod] [int] NULL,
	[OverTime] [int] NULL,
	[Deduction] [decimal](15, 4) NULL,
	[Salary] [int] NULL,
	[SessionName] [varchar](50) NULL,
	[OAmount] [int] NULL,
	[DAmount] [int] NULL,
	[TAmount] [int] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[DStatus] [varchar](10) NULL,
	[Stipend] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[StipendDetail]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[StipendDetail](
	[StipendID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[StipendAmount] [int] NULL,
	[Status] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[EmpID] [int] NULL,
	[StartSession] [varchar](50) NULL,
	[Description] [varchar](250) NULL,
	[SessionEndDate] [varchar](50) NULL,
 CONSTRAINT [PK_Stipend] PRIMARY KEY CLUSTERED 
(
	[StipendID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[temp]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[temp](
	[RegisterID] [int] IDENTITY(1,1) NOT NULL,
	[EmployeeID] [int] NULL,
	[EmployeeCode] [varchar](10) NULL,
	[CompanyID] [varchar](50) NULL,
	[Department] [varchar](100) NULL,
	[Designation] [varchar](100) NULL,
	[PostingCity] [varchar](20) NULL,
	[CompanyEmail] [varchar](50) NULL,
	[JoiningDate] [varchar](50) NULL,
	[Status] [varchar](15) NULL,
	[ReportingTo] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[DeletedBy] [varchar](50) NULL,
	[DeletedOn] [datetime] NULL,
	[ReportingTo2] [varchar](50) NULL,
	[JobShift] [varchar](100) NULL,
	[Salary] [int] NULL,
	[Stipend] [int] NULL,
	[JobStatus] [varchar](20) NULL,
	[ProbationEnd] [varchar](20) NULL,
	[JobDescription] [text] NULL,
	[ChildCompany] [int] NULL,
	[SendNotification] [varchar](20) NULL,
	[AllowEmployeesAttendance] [varchar](10) NULL,
	[EportalAccess] [varchar](10) NULL,
	[ExpStatus] [varchar](5) NULL,
	[EduStatus] [varchar](5) NULL,
	[DocStatus] [varchar](10) NULL,
	[RegDate] [varchar](50) NULL,
	[MethodType] [varchar](50) NULL,
	[BankAccount] [varchar](50) NULL,
	[bank_name] [varchar](100) NULL,
	[account_name] [varchar](100) NULL,
	[remarks] [varchar](max) NULL,
	[CompanyName] [varchar](100) NULL,
	[SuspensionEnd] [varchar](50) NULL,
	[AllowAttendance] [varchar](10) NULL,
	[ResignDate] [varchar](50) NULL,
	[TerminateDate] [varchar](50) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TEMPPayroll_Distribution]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TEMPPayroll_Distribution](
	[DistributionID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](255) NULL,
	[EmployeeID] [int] NULL,
	[Name] [varchar](50) NULL,
	[EmpCode] [varchar](10) NULL,
	[Department] [varchar](100) NULL,
	[Designation] [varchar](100) NULL,
	[PostingCity] [varchar](20) NULL,
	[SessionName] [varchar](255) NULL,
	[Mobile] [varchar](20) NULL,
	[CNIC] [varchar](20) NULL,
	[Address] [varchar](500) NULL,
	[Photo] [varchar](255) NULL,
	[MethodType] [varchar](50) NULL,
	[BankAcc] [varchar](50) NULL,
	[BankName] [varchar](100) NULL,
	[AccountName] [varchar](100) NULL,
	[FinanceApprovalID] [int] NULL,
	[Salary] [int] NULL,
	[OAmount] [int] NULL,
	[DAmount] [int] NULL,
	[TAmount] [int] NULL,
	[InstallmentNo] [varchar](50) NULL,
	[InstallmentAmount] [int] NULL,
	[Fine] [int] NULL,
	[DuesAmount] [int] NULL,
	[ArrearsAmount] [int] NULL,
	[BonusAmount] [int] NULL,
	[AllowanceAmount] [int] NULL,
	[PayableSalary] [int] NULL,
	[DStatus] [varchar](10) NULL,
	[HrStatus] [varchar](50) NULL,
	[FStatus] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[ReceivedThrough] [varchar](255) NULL,
	[ReceivedTime] [varchar](50) NULL,
	[AdvanceAmount] [int] NULL,
	[FuelAmount] [int] NULL,
	[FuelReceivable] [int] NULL,
	[TaxAmount] [int] NULL,
	[StipendAmount] [int] NULL,
	[CompanyName] [varchar](100) NULL,
	[BankPayable] [int] NULL,
	[CashPayable] [int] NULL,
	[CashAmount] [int] NULL,
	[BankAmount] [int] NULL,
	[CashID] [bigint] NULL,
	[BankID] [bigint] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TimeAdjustment]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TimeAdjustment](
	[TimeAdjId] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeID] [int] NULL,
	[TimeAdjFor] [varchar](30) NULL,
	[Hours] [varchar](50) NULL,
	[Minutes] [varchar](50) NULL,
	[ManagerApproval] [varchar](20) NULL,
	[HrApproval] [varchar](20) NULL,
	[ReqStatus] [varchar](20) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[att_date] [varchar](50) NULL,
	[Reason] [varchar](200) NULL,
PRIMARY KEY CLUSTERED 
(
	[TimeAdjId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[universties_boards]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[universties_boards](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[Institutes_name] [varchar](100) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Warning_Letter]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Warning_Letter](
	[LetterID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[DateIssued] [varchar](50) NULL,
	[EmployeeID] [varchar](50) NULL,
	[EmployeeName] [varchar](50) NULL,
	[Department] [varchar](50) NULL,
	[Designation] [varchar](50) NULL,
	[Location] [varchar](50) NULL,
	[WarningType] [varchar](50) NULL,
	[ReasonSubject] [varchar](500) NULL,
	[ReasonContent] [varchar](550) NULL,
	[CreatedBy] [varchar](30) NULL,
	[CreatedOn] [varchar](50) NULL,
	[updatedBy] [varchar](30) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[WarningContent] [varchar](max) NULL,
 CONSTRAINT [PK__Warning___A6F3C31C03F12D4A] PRIMARY KEY CLUSTERED 
(
	[LetterID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Warning_Reason]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Warning_Reason](
	[ReasonID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](100) NULL,
	[ReasonName] [varchar](100) NULL,
	[ReasonContent] [varchar](500) NULL,
	[CreatedBy] [varchar](30) NULL,
	[CreatedOn] [datetime] NULL,
PRIMARY KEY CLUSTERED 
(
	[ReasonID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[AttData] ADD  CONSTRAINT [DF_AttData_GracePeriod]  DEFAULT ((0)) FOR [GracePeriod]
GO
ALTER TABLE [dbo].[AttData] ADD  CONSTRAINT [DF_AttData_Overtime]  DEFAULT ((0)) FOR [Overtime]
GO
ALTER TABLE [dbo].[Emp_Profile] ADD  CONSTRAINT [DF_Emp_Profile_CreatedOn]  DEFAULT (getdate()) FOR [CreatedOn]
GO
ALTER TABLE [dbo].[Emp_Register] ADD  CONSTRAINT [DF_Emp_Register_CreatedOn]  DEFAULT (getdate()) FOR [CreatedOn]
GO
ALTER TABLE [dbo].[EmpGraceHours] ADD  CONSTRAINT [DF_EmpGraceHours_TotalGP]  DEFAULT ((0)) FOR [TotalGP]
GO
ALTER TABLE [dbo].[Employee_Dep_Comp] ADD  CONSTRAINT [DF_Employee_Dep_Comp_Status]  DEFAULT ('Active') FOR [Status]
GO
ALTER TABLE [dbo].[Employee_Dep_Comp] ADD  CONSTRAINT [DF_Employee_Dep_Comp_IsDeleted_1]  DEFAULT ((0)) FOR [IsDeleted]
GO
ALTER TABLE [dbo].[Employee_Qualification] ADD  CONSTRAINT [DF_Employee_Qualification_created_time]  DEFAULT (getdate()) FOR [CreatedOn]
GO
ALTER TABLE [dbo].[Employee_Qualification] ADD  CONSTRAINT [DF_Employee_Qualification_updated_time]  DEFAULT (getdate()) FOR [UpdatedOn]
GO
ALTER TABLE [dbo].[FinalSettlement] ADD  CONSTRAINT [DF_FinalSettlement_LoanAmount]  DEFAULT ((0)) FOR [LoanAmount]
GO
ALTER TABLE [dbo].[FinalSettlement] ADD  CONSTRAINT [DF_Payroll_Settlement_Fine]  DEFAULT ((0)) FOR [Fine]
GO
ALTER TABLE [dbo].[FinalSettlement] ADD  CONSTRAINT [DF_Payroll_Settlement_DuesAmount]  DEFAULT ((0)) FOR [DuesAmount]
GO
ALTER TABLE [dbo].[FinalSettlement] ADD  CONSTRAINT [DF_Payroll_Settlement_ArrearsAmount]  DEFAULT ((0)) FOR [ArrearsAmount]
GO
ALTER TABLE [dbo].[FinalSettlement] ADD  CONSTRAINT [DF_Payroll_Settlement_BonusAmount]  DEFAULT ((0)) FOR [BonusAmount]
GO
ALTER TABLE [dbo].[FinalSettlement] ADD  CONSTRAINT [DF_Payroll_Settlement_AllowanceAmount]  DEFAULT ((0)) FOR [AllowanceAmount]
GO
ALTER TABLE [dbo].[FinalSettlement] ADD  CONSTRAINT [DF_FinalSettlement_SettlementAmount]  DEFAULT ((0)) FOR [SettlementAmount]
GO
ALTER TABLE [dbo].[FinalSettlement] ADD  CONSTRAINT [DF_FinalSettlement_Gratuity]  DEFAULT ((0)) FOR [Gratuity]
GO
ALTER TABLE [dbo].[FinalSettlement] ADD  CONSTRAINT [DF_FinalSettlement_PayableSalary]  DEFAULT ((0)) FOR [PayableSalary]
GO
ALTER TABLE [dbo].[FinalSettlement] ADD  CONSTRAINT [DF_FinalSettlement_IsDeleted_1]  DEFAULT ((0)) FOR [IsDeleted]
GO
ALTER TABLE [dbo].[FinalSettlement] ADD  CONSTRAINT [DF_FinalSettlement_BankAmount]  DEFAULT ((0)) FOR [BankAmount]
GO
ALTER TABLE [dbo].[HrSessions] ADD  CONSTRAINT [DF_HrSessions_DistState]  DEFAULT ((0)) FOR [DistState]
GO
ALTER TABLE [dbo].[leave_Requisition] ADD  CONSTRAINT [DF_leave_Requisition_HRApproval]  DEFAULT ('Pending') FOR [HRApproval]
GO
ALTER TABLE [dbo].[leave_Requisition] ADD  CONSTRAINT [DF_leave_Requisition_ManagerApproval]  DEFAULT ('Pending') FOR [ManagerApproval]
GO
ALTER TABLE [dbo].[LoanDetail] ADD  CONSTRAINT [DF_LoanDetail_IsDeleted]  DEFAULT ((0)) FOR [IsDeleted]
GO
ALTER TABLE [dbo].[LoanRequisition] ADD  CONSTRAINT [DF_LoanRequisition_IsDeleted]  DEFAULT ((0)) FOR [IsDeleted]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_Photo]  DEFAULT ('pro.png') FOR [Photo]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_Salary]  DEFAULT ((0)) FOR [Salary]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_OAmount]  DEFAULT ((0)) FOR [OAmount]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_DAmount]  DEFAULT ((0)) FOR [DAmount]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_TAmount]  DEFAULT ((0)) FOR [TAmount]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_InstallmentAmount]  DEFAULT ((0)) FOR [InstallmentAmount]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_Fine]  DEFAULT ((0)) FOR [Fine]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_DuesAmount]  DEFAULT ((0)) FOR [DuesAmount]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_ArrearsAmount]  DEFAULT ((0)) FOR [ArrearsAmount]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_BonusAmount]  DEFAULT ((0)) FOR [BonusAmount]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_AllowanceAmount]  DEFAULT ((0)) FOR [AllowanceAmount]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_PayableSalary]  DEFAULT ((0)) FOR [PayableSalary]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_AdvanceAmount]  DEFAULT ((0)) FOR [AdvanceAmount]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_FuelAmount]  DEFAULT ((0)) FOR [FuelAmount]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_FuelReceivable]  DEFAULT ((0)) FOR [FuelReceivable]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_TaxAmount]  DEFAULT ((0)) FOR [TaxAmount]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_StipendAmount]  DEFAULT ((0)) FOR [StipendAmount]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_BankPayable]  DEFAULT ((0)) FOR [BankPayable]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_CashPayable]  DEFAULT ((0)) FOR [CashPayable]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_CashAmount]  DEFAULT ((0)) FOR [CashAmount]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_BankAmount]  DEFAULT ((0)) FOR [BankAmount]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_RemainingAmount]  DEFAULT ((0)) FOR [RemainingAmount]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_PaidAmount]  DEFAULT ((0)) FOR [PaidAmount]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_PNO]  DEFAULT ((0)) FOR [PNO]
GO
ALTER TABLE [dbo].[Payroll_Distribution] ADD  CONSTRAINT [DF_Payroll_Distribution_CurrentCashPaid]  DEFAULT ((0)) FOR [CurrentCashPaid]
GO
ALTER TABLE [dbo].[PayrollArrears] ADD  CONSTRAINT [DF_PayrollArrears_IsDeleted]  DEFAULT ((0)) FOR [IsDeleted]
GO
ALTER TABLE [dbo].[PayrollFinanceApproval] ADD  CONSTRAINT [DF_PayrollFinanceApproval_Fine]  DEFAULT ((0)) FOR [Fine]
GO
ALTER TABLE [dbo].[PayrollFinanceApproval] ADD  CONSTRAINT [DF_PayrollFinanceApproval_DuesAmount]  DEFAULT ((0)) FOR [DuesAmount]
GO
ALTER TABLE [dbo].[PayrollFinanceApproval] ADD  CONSTRAINT [DF_PayrollFinanceApproval_ArrearsAmount]  DEFAULT ((0)) FOR [ArrearsAmount]
GO
ALTER TABLE [dbo].[PayrollFinanceApproval] ADD  CONSTRAINT [DF_PayrollFinanceApproval_BonusAmount]  DEFAULT ((0)) FOR [BonusAmount]
GO
ALTER TABLE [dbo].[PayrollFinanceApproval] ADD  CONSTRAINT [DF_PayrollFinanceApproval_AllowanceAmount]  DEFAULT ((0)) FOR [AllowanceAmount]
GO
ALTER TABLE [dbo].[PayrollFinanceApproval] ADD  CONSTRAINT [DF_PayrollFinanceApproval_PayableSalary]  DEFAULT ((0)) FOR [PayableSalary]
GO
ALTER TABLE [dbo].[PayrollFinanceApproval] ADD  CONSTRAINT [DF_PayrollFinanceApproval_AdvanceAmount]  DEFAULT ((0)) FOR [AdvanceAmount]
GO
ALTER TABLE [dbo].[PayrollFinanceApproval] ADD  CONSTRAINT [DF_PayrollFinanceApproval_FuelAmount]  DEFAULT ((0)) FOR [FuelAmount]
GO
ALTER TABLE [dbo].[PayrollFinanceApproval] ADD  CONSTRAINT [DF_PayrollFinanceApproval_FuelReceivable]  DEFAULT ((0)) FOR [FuelReceivable]
GO
ALTER TABLE [dbo].[PayrollFinanceApproval] ADD  CONSTRAINT [DF_PayrollFinanceApproval_TaxAmount]  DEFAULT ((0)) FOR [TaxAmount]
GO
ALTER TABLE [dbo].[PayrollFinanceApproval] ADD  CONSTRAINT [DF_PayrollFinanceApproval_StipendAmount]  DEFAULT ((0)) FOR [StipendAmount]
GO
ALTER TABLE [dbo].[PayrollFinanceApproval] ADD  CONSTRAINT [DF_PayrollFinanceApproval_BankPayable]  DEFAULT ((0)) FOR [BankPayable]
GO
ALTER TABLE [dbo].[PayrollFinanceApproval] ADD  CONSTRAINT [DF_PayrollFinanceApproval_CashPayable]  DEFAULT ((0)) FOR [CashPayable]
GO
ALTER TABLE [dbo].[Roasters] ADD  CONSTRAINT [DF_Roasters_CreatedOn]  DEFAULT (getdate()) FOR [CreatedOn]
GO
ALTER TABLE [dbo].[Roasters] ADD  CONSTRAINT [DF_Roasters_IsDeleted]  DEFAULT ((0)) FOR [IsDeleted]
GO
ALTER TABLE [dbo].[SessionReport] ADD  CONSTRAINT [DF_SessionReport_TotalAbsent]  DEFAULT ((0)) FOR [TotalAbsent]
GO
ALTER TABLE [dbo].[SessionReport] ADD  CONSTRAINT [DF_SessionReport_TotalLeave]  DEFAULT ((0)) FOR [TotalLeave]
GO
ALTER TABLE [dbo].[SessionReport] ADD  CONSTRAINT [DF_SessionReport_GracePeriod]  DEFAULT ((0)) FOR [GracePeriod]
GO
ALTER TABLE [dbo].[SessionReport] ADD  CONSTRAINT [DF_SessionReport_OverTime]  DEFAULT ((0)) FOR [OverTime]
GO
ALTER TABLE [dbo].[SessionReport] ADD  CONSTRAINT [DF_SessionReport_Deduction]  DEFAULT ((0)) FOR [Deduction]
GO
ALTER TABLE [dbo].[SessionReport] ADD  CONSTRAINT [DF_SessionReport_Salary]  DEFAULT ((0)) FOR [Salary]
GO
ALTER TABLE [dbo].[SessionReport] ADD  CONSTRAINT [DF_SessionReport_OAmount]  DEFAULT ((0)) FOR [OAmount]
GO
ALTER TABLE [dbo].[SessionReport] ADD  CONSTRAINT [DF_SessionReport_DAmount]  DEFAULT ((0)) FOR [DAmount]
GO
ALTER TABLE [dbo].[SessionReport] ADD  CONSTRAINT [DF_SessionReport_TAmount]  DEFAULT ((0)) FOR [TAmount]
GO
ALTER TABLE [dbo].[SessionReport] ADD  CONSTRAINT [DF_SessionReport_Stipend]  DEFAULT ((0)) FOR [Stipend]
GO
ALTER TABLE [dbo].[Candidate_Detail]  WITH CHECK ADD  CONSTRAINT [FK__Candidate__JobID__2022C2A6] FOREIGN KEY([JobID])
REFERENCES [dbo].[Post_Job] ([JobID])
GO
ALTER TABLE [dbo].[Candidate_Detail] CHECK CONSTRAINT [FK__Candidate__JobID__2022C2A6]
GO
ALTER TABLE [dbo].[Candidate_Detail]  WITH CHECK ADD  CONSTRAINT [FK__Candidate__JobID__2116E6DF] FOREIGN KEY([JobID])
REFERENCES [dbo].[Post_Job] ([JobID])
GO
ALTER TABLE [dbo].[Candidate_Detail] CHECK CONSTRAINT [FK__Candidate__JobID__2116E6DF]
GO
ALTER TABLE [dbo].[Candidate_Detail]  WITH CHECK ADD  CONSTRAINT [FK_Candidate_Detail_Candidate_Detail] FOREIGN KEY([CandID])
REFERENCES [dbo].[Candidate_Detail] ([CandID])
GO
ALTER TABLE [dbo].[Candidate_Detail] CHECK CONSTRAINT [FK_Candidate_Detail_Candidate_Detail]
GO
ALTER TABLE [dbo].[Candidate_Detail]  WITH CHECK ADD  CONSTRAINT [FK_Candidates_Candidates] FOREIGN KEY([CandID])
REFERENCES [dbo].[Candidate_Detail] ([CandID])
GO
ALTER TABLE [dbo].[Candidate_Detail] CHECK CONSTRAINT [FK_Candidates_Candidates]
GO
ALTER TABLE [dbo].[Emp_Profile]  WITH CHECK ADD  CONSTRAINT [FK_Emp_Register_Emp_Profile] FOREIGN KEY([EmployeeID])
REFERENCES [dbo].[Emp_Profile] ([EmployeeID])
GO
ALTER TABLE [dbo].[Emp_Profile] CHECK CONSTRAINT [FK_Emp_Register_Emp_Profile]
GO
ALTER TABLE [dbo].[interview_detail]  WITH CHECK ADD  CONSTRAINT [FK__interview__CandI__25DB9BFC] FOREIGN KEY([CandID])
REFERENCES [dbo].[Candidate_Detail] ([CandID])
GO
ALTER TABLE [dbo].[interview_detail] CHECK CONSTRAINT [FK__interview__CandI__25DB9BFC]
GO
ALTER TABLE [dbo].[interview_detail]  WITH CHECK ADD  CONSTRAINT [FK__interview__CandI__26CFC035] FOREIGN KEY([CandID])
REFERENCES [dbo].[Candidate_Detail] ([CandID])
GO
ALTER TABLE [dbo].[interview_detail] CHECK CONSTRAINT [FK__interview__CandI__26CFC035]
GO
/****** Object:  StoredProcedure [dbo].[Add_Absent]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Add_Absent]
as begin 
UPDATE    AttData
     set  AttStatus   = 'A'
    
     where AttStatus   is null 
     and   CheckIN     is null
     and   OpeningTime <   (select (substring (convert (varchar (20),getdate (),120) ,12,5)))
     and   ATTDate     = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
	 select '[Absent]' as 'Absent'
    
     
     
     end
    
GO
/****** Object:  StoredProcedure [dbo].[Add_AutoCheckout]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create Procedure [dbo].[Add_AutoCheckout]
as begin 

Update AttData
set CheckOut   =  ClosingTime , 
    CheckOutBy = 'Auto_CheckOut'
where ClosingTime <= (SELECT substring (convert(varchar(8), getdate(), 108),1,5))
and CheckOut is null and CheckIN is not null
and ATTDate = (SELECT (substring(convert(VARCHAR(10), getdate(), 120), 1, 10)))
end
GO
/****** Object:  StoredProcedure [dbo].[Add_EmpAttData]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure   [dbo].[Add_EmpAttData]
as begin

  insert into [HRMS_SAG_REPLICA].[dbo].[AttData] 
              (CompanyID ,RosterID  ,EmpID,ATTDate         ,Location     ,EmpCode)
  select      [CompanyID],[JobShift],[EmployeeID],getdate(),[PostingCity], [EmployeeCode] 
  from        Emp_Register
  where Status in ('Registered', 'Suspended')
  end
GO
/****** Object:  StoredProcedure [dbo].[Add_GracePeriod]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Add_GracePeriod]
--cron job to calculate daily used GracePeriod
As
 Begin
Create table #temptime (id int,minutess varchar (20) , mint varchar (20)  )
Insert into  #temptime
Select  EmpID, sum(cast(DATEDIFF(MI,  cast (OpeningTime as time(7)),CheckIN)as int)), sum(cast(DATEDIFF(MI,CheckOut, cast (ClosingTime as time(7)))as int))
From    AttData
Where   ATTDate     = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
And     AttStatus   in ('L','P')
group by EmpID
update    AttData          
set       GracePeriod  =  (case when  minutess < 0 then 0 else minutess end + case when  mint < 0 then 0 else mint end )
from      AttData    a
join      #temptime  t
on        a.EmpID      =  t.id
where     ATTDate      = (select (substring (convert (varchar(10),getdate (),120) ,1,10 ))) -- to get only date from getdate to match the format of data in attdata
drop      table        #temptime
                 end
GO
/****** Object:  StoredProcedure [dbo].[Add_holiday]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Add_holiday]
as begin 

Update AttData
set AttStatus = 'H'
where OpeningTime = '-'
and AttDate   = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
select 'Chutti' as Holiday
end
GO
/****** Object:  StoredProcedure [dbo].[Add_Late]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Add_Late]
as begin 
 create table #temptb (id int, CheckIN varchar (8))
 insert into  #temptb
select EmpID ,CheckIN 
from   AttData  
where OpeningTime is not null and  OpeningTime != '-' and
cast (OpeningTime as time(7) ) <  CheckIN
AND    ATTDate     =  (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
--select * from #temptb
--drop table #temptb
update AttData
set    AttStatus  = 'L'
from   AttData a
join   #temptb t
on     a.EmpID = t.id
WHERE  a.ATTDate    = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
AND    a.CheckIN      IS NOT NULL
select * from #temptb

end 
GO
/****** Object:  StoredProcedure [dbo].[Add_Leave]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
 CREATE PROCEDURE [dbo].[Add_Leave]
 AS
  BEGIN
 

 
 create table #temptb (id int, LeaveType varchar (20))
 insert into  #temptb
 SELECT       [EmployeeID]  ,Leavetype
 FROM         leave_Requisition 
 WHERE        PendingLeaveStatus = 'A' 
 AND          EndDate            >= (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
 AND          StartDate          <= (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
 UPDATE AttData
 SET    AttStatus  = (case when t.LeaveType = 'UnPaid' then 'UL' else 'LE' end)
 from   AttData a
 join   #temptb t
 on     a.EmpID    = t.id
 WHERE  ATTDate    = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
 AND    [CheckIN]  IS NULL
   
   --DROP TABLE #TMP_DATE
      select * from  #temptb

   DROP TABLE #temptb
END
GO
/****** Object:  StoredProcedure [dbo].[Add_OverTime]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Add_OverTime]

As
 Begin

Create table #temptime (id int,minutess varchar (10))
Insert into  #temptime

Select  EmpID,      cast (DATEDIFF(MI, ClosingTime, CheckOut ) as varchar (10)) 
From    AttData
Where   ATTDate     = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
And     cast (ClosingTime as time(7) ) < CheckOut



  update     AttData 
  set        Overtime    = CONVERT(INT, t.minutess)
  from       AttData a
  join       #temptime t
  on         a.EmpID     = t.id
  where      ATTDate     = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))


  select * from #temptime

  drop       table         #temptime
                    end

GO
/****** Object:  StoredProcedure [dbo].[Add_Payroll_Distribution]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Add_Payroll_Distribution]
@companyID varchar (255) ,
@session varchar (255)

as begin 

insert into  [dbo].[Payroll_Distribution]
(
 CompanyID  , EmployeeID , Name ,EmpCode  ,Department ,Designation ,PostingCity,[SessionName] ,Mobile ,CNIC,Address ,Photo ,MethodType 
,BankAcc ,BankName ,AccountName ,[FinanceApprovalID] ,[Salary] ,[OAmount] ,[DAmount] ,[TAmount] ,[InstallmentNo] ,InstallmentAmount ,[Fine],[DuesAmount],[ArrearsAmount],[BonusAmount],[AllowanceAmount]
,[PayableSalary]  ,[DStatus] ,[HrStatus],[FStatus] ,[UpdatedBy] ,[UpdatedOn] ,[AdvanceAmount] ,[FuelAmount] ,[FuelReceivable],[TaxAmount],[StipendAmount],[RemainingAmount],PNO,SalaryStatus
)
select
 p.CompanyID ,p.EmployeeID ,p.Name ,r.EmployeeCode  ,r.Department,r.Designation ,r.PostingCity,f.SessionName,p.Mobile ,p.CNIC,p.Address,
p.Photo ,r.MethodType,r.BankAccount ,r.bank_name ,r.account_name ,f.[FinanceApprovalID] ,f.[Salary] ,f.[OAmount] ,f.[DAmount] ,f.[TAmount] ,f.[InstallmentNo] ,
f.[InstallmentAmount] ,f.[Fine],f.[DuesAmount],f.[ArrearsAmount],f.[BonusAmount],f.[AllowanceAmount],f.[PayableSalary]  ,f.[DStatus] ,f.[HrStatus],f.[FStatus] ,f.[UpdatedBy] ,f.[UpdatedOn] ,f.[AdvanceAmount] ,f.[FuelAmount] ,f.[FuelReceivable] ,f.[TaxAmount] ,f.StipendAmount,f.[PayableSalary],0,'Not Received'
from [dbo].[Emp_Profile] p
join [dbo].[Emp_Register]  r on p.EmployeeID = r.EmployeeID
join [dbo].[PayrollFinanceApproval] f on r.EmployeeID =f.EmployeeID
where  p.CompanyID = @companyID
and    f.SessionName = @session
and    f.FStatus = 'P'
and    r.Status  = 'Registered'
end
GO
/****** Object:  StoredProcedure [dbo].[Add_Present]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Add_Present] 
as
begin
update AttData
set    AttStatus = 'P'
from   AttData a 
join   Emp_Register r  on a.EmpCode = r.EmployeeCode
where  a.ATTDate   = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
and    a.CheckIN   is not null
and    r.Status    <> 'Suspended'  

select 'Present' as Present
end
GO
/****** Object:  StoredProcedure [dbo].[Add_PunchTime]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Add_PunchTime]
as begin 

   ;with cte as (
  
SELECT
     
       cast([Check_In_Time]as time(7)) as checkin
      , cast([Check_Out_Time]as time(7)) as checkout
	   ,[Employee_Code] as EMpCode
	    , (select (substring (convert (varchar(10),[AttendanceDate],120) ,1,10 ))) as TodayDate
  FROM [192.168.11.161].[SA_MIS].[dbo].[AttendanceData]
  where
  (select  (substring (convert (varchar(10),AttendanceDate,120) ,1,10 )))  = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
  

)
  select * into #time 
  from     cte

  update AttData
  set    AttData.CheckIN  =  t.checkin   , AttData.CheckOut    =   t.checkout  
  from   AttData
  join   #time t 
  on     AttData.EmpCode = t.EMpCode
  where  AttData.CheckIN  is   null
  and    AttData.CheckOut  is null
  and    ATTDate = TodayDate
  select * from #time
  drop   table #time
 end
GO
/****** Object:  StoredProcedure [dbo].[Add_Roastertime]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure     [dbo].[Add_Roastertime] 
as begin
set nocount on 
 declare @date VARCHAR (3)
 set     @date=(select substring(datename  (dw,getdate()),1,3))
 if 
         @date = 'Tue'
begin 
CREATE TABLE #TMPTIME1 (ID INT ,  CTIME VARCHAR(6),OTIME VARCHAR (6))
INSERT INTO  #TMPTIME1
select       [EmployeeID] , substring (Tue,7,len(Tue))  ,substring (Tue,1,5) 
from         Roasters r  
join         Emp_Register a
on           r.RosterID = a.JobShift
update     [AttData]
set        [ClosingTime] = T.CTIME , [OpeningTime] = T.OTIME
FROM       AttData A
JOIN       #TMPTIME1 T
ON         T.ID = A.EmpID
where      ATTDate = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
DROP TABLE #TMPTIME1
end
 else if
         @date = 'Mon'
begin 
CREATE TABLE #TMPTIME2 (ID INT ,  CTIME VARCHAR(6),OTIME VARCHAR (6))
INSERT INTO  #TMPTIME2
select       [EmployeeID] ,substring (Mon,7,len(Mon)) , substring (Mon,1,5) 
from         Roasters r  
join         Emp_Register a
on           r.RosterID = a.JobShift
update     [AttData]
set        [ClosingTime] = T2.CTIME , [OpeningTime] = T2.OTIME
FROM       AttData A
JOIN       #TMPTIME2 T2
ON         T2.ID = A.EmpID
where      ATTDate = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
DROP TABLE #TMPTIME2
  end
  else 
 if 
         @date = 'Wed'
begin 
CREATE TABLE #TMPTIME3 (ID INT ,  CTIME VARCHAR(6),OTIME VARCHAR (6))
INSERT INTO  #TMPTIME3
select       [EmployeeID] ,substring (Wed,7,len(Wed)) , substring (Wed,1,5) 
from         Roasters r  
join         Emp_Register a
on           r.RosterID = a.JobShift
update     [AttData]
set        [ClosingTime] = T3.CTIME , [OpeningTime] = T3.OTIME
FROM       AttData A
JOIN       #TMPTIME3 T3
ON         T3.ID = A.EmpID
where      ATTDate = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
DROP TABLE #TMPTIME3
  end
  else   
 if 
         @date = 'Thu'
begin 
CREATE TABLE #TMPTIME4 (ID INT ,  CTIME VARCHAR(6),OTIME VARCHAR (6))
INSERT INTO  #TMPTIME4
select       [EmployeeID] ,substring (Thu,7,len(Thu)),substring (Thu,1,5) 
from         Roasters r  
join         Emp_Register a
on           r.RosterID = a.JobShift
update     [AttData]
set        [ClosingTime] = T4.CTIME , [OpeningTime] = T4.OTIME
FROM       AttData A
JOIN       #TMPTIME4 T4
ON         T4.ID = A.EmpID
where      ATTDate = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
DROP TABLE #TMPTIME4
  end
   else
 if 
         @date = 'Fri'
begin 
CREATE TABLE #TMPTIME5 (ID INT ,  CTIME VARCHAR(6),OTIME VARCHAR (6))
INSERT INTO  #TMPTIME5
select       [EmployeeID] ,substring (Fri,7,len(Fri)) , substring (Fri,1,5)
from         Roasters r  
join         Emp_Register a
on           r.RosterID = a.JobShift
update     [AttData]
set        [ClosingTime] = T5.CTIME , [OpeningTime] = T5.OTIME
FROM       AttData A
JOIN       #TMPTIME5 T5
ON         T5.ID = A.EmpID
where      ATTDate = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
DROP TABLE #TMPTIME5
  end
  else 
 if 
         @date = 'Sat'
begin 
CREATE TABLE #TMPTIME6 (ID INT ,  CTIME VARCHAR(6),OTIME VARCHAR (6))
INSERT INTO  #TMPTIME6
select       [EmployeeID] ,substring (Sat,7,len(Sat)),substring (Sat,1,5) 
from         Roasters r  
join         Emp_Register a
on           r.RosterID = a.JobShift
update     [AttData]
set        [ClosingTime] = T6.CTIME , [OpeningTime] = T6.OTIME
FROM       AttData A
JOIN       #TMPTIME6 T6
ON         T6.ID = A.EmpID
where      ATTDate = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
DROP TABLE #TMPTIME6
  end
  else
  if 
         @date = 'Sun'
begin 
CREATE TABLE #TMPTIME7 (ID INT ,  CTIME VARCHAR(6),OTIME VARCHAR (6))
INSERT INTO  #TMPTIME7
select       [EmployeeID] ,substring (Sun,7,len(Sun)),substring (Sun,1,5) 
from         Roasters r  
join         Emp_Register a
on           r.RosterID = a.JobShift
update     [AttData]
set        [ClosingTime] = T7.CTIME , [OpeningTime] = T7.OTIME
FROM       AttData A
JOIN       #TMPTIME7 T7
ON         T7.ID = A.EmpID
where      ATTDate = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
DROP TABLE #TMPTIME7
  end
  end
GO
/****** Object:  StoredProcedure [dbo].[AllowancesReport]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

create procedure [dbo].[AllowancesReport]


as begin 

SELECT 
    p.SessionName,
    SUM(p.[BonusAmount])      [BonusAmount],
	SUM(p.[AllowanceAmount])  [AllowanceAmount],
    SUM(p.[ArrearsAmount])    [ArrearsAmount],
	SUM(p.[FuelAmount])       [FuelAmount],
    SUM(p.[OAmount])          Overtime,
	SUM(p.[StipendAmount])    [StipendAmount]

FROM [HRMS_SAG_REPLICA].[dbo].[Payroll_Distribution] p
GROUP BY p.SessionName
order by p.SessionName desc
end 

GO
/****** Object:  StoredProcedure [dbo].[Arrear_Report]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create procedure [dbo].[Arrear_Report]
@date date,
@date1 date ,
@Dep varchar (100) 

as begin

select p.Name ,r.EmployeeCode ,r.Department,l.ArrearsAmount ,l.Descriptions,l.Status,l.ArrearDate  from [dbo].[PayrollArrears] l
join Emp_profile p on l.EmployeeID = p.EmployeeID
join Emp_Register r on l.EmployeeID = r.EmployeeID
where  l.ArrearDate between   @date  and @date1
and    r.Department = case when @Dep = '' then r.Department else @Dep end 
end
GO
/****** Object:  StoredProcedure [dbo].[Calculate_Late]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create procedure [dbo].[Calculate_Late] 
as begin 
set nocount on  

 ;with cte as (
 SELECT  cast (concat(OpeningTime,':00.000000')as time) as [Minutess]  ,*
  FROM [HRMS_SAG_REPLICA].[dbo].[AttData]
  where OpeningTime is not null and OpeningTime <> '-'
  and ATTDate  =(select (substring (convert (varchar(10),getdate (),120) ,1,10 ))))
  ,  ctee as (
  SELECT DATEDIFF(MINUTE, [Minutess], CheckIN) AS [Minutes],* FROM cte
 )
 select EmpID ,
 case when sign([Minutes]) = -1 then 0 else [Minutes] end as [Minutes]
  into #temp
 FROM ctee


 update [AttData]
 set Late = c.[Minutes]
 from [AttData] a 
 join #temp c on a.EmpID = c.EmpID
 where    ATTDate  =(select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
 and Late is null  


 end 
GO
/****** Object:  StoredProcedure [dbo].[Companywise_Salary]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE procedure [dbo].[Companywise_Salary]

as begin
SELECT
    p.SessionName,
    r.CompanyName,
    SUM(p.PayableSalary)  PayableSalary
FROM [dbo].[Payroll_Distribution] p
inner join Emp_Register r on p.EmpCode = r.EmployeeCode
GROUP BY p.SessionName, r.CompanyName
order by r.CompanyName,p.SessionName desc
end
GO
/****** Object:  StoredProcedure [dbo].[Companywise_Salary_Pivoted]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

create procedure [dbo].[Companywise_Salary_Pivoted]


as begin 

DECLARE @cols AS NVARCHAR(MAX),
@query AS NVARCHAR(MAX)

SET @cols = STUFF((SELECT ',' + QUOTENAME(SessionName)
FROM [HRMS_SAG_REPLICA].[dbo].[Payroll_Distribution]
GROUP BY SessionName
FOR XML PATH(''), TYPE
).value('.', 'NVARCHAR(MAX)'),1,1,'')

SET @query = 'SELECT CompanyName, ' + @cols + '
from
(
SELECT r.CompanyName, p.SessionName, SUM(p.PayableSalary) PayableSalary
FROM [HRMS_SAG_REPLICA].[dbo].[Payroll_Distribution] p
inner join Emp_Register r on p.EmpCode = r.EmployeeCode
GROUP BY p.SessionName, r.CompanyName
) x
pivot
(
SUM(PayableSalary)
for SessionName in (' + @cols + ')
) p '

EXECUTE(@query)



end
GO
/****** Object:  StoredProcedure [dbo].[Employee_AVG_Time]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE Procedure  [dbo].[Employee_AVG_Time]
@STARTDATE DATE ,
@ENDDATE DATE,
@Id int
as begin
SELECT p.name
,[EmpID]
,[EmpCode],
      [RosterID]
      ,cast(cast(avg(cast(CAST([CheckIN] as datetime) as float)) as datetime) as time(7)) AvgCheckINTime,
        cast(cast(avg(cast(CAST([CheckOut] as datetime) as float)) as datetime) as time(7)) AvgCheckOutTime,
      [OpeningTime]
      ,[ClosingTime]
  FROM [dbo].[AttData] a
  join Emp_Profile p on a.EmpID = p.EmployeeID
  where [OpeningTime] <> '-'
  and [OpeningTime] is not null
  and cast(AttDAte as date ) between @STARTDATE and @ENDDATE and p.EmployeeID = @Id
  group by p.name,[OpeningTime]
      ,[ClosingTime]
      ,[EmpCode],[EmpID],
      [RosterID]
	  order by [EmpID] desc
	  end
GO
/****** Object:  StoredProcedure [dbo].[GET_DepartmentAttReport]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[GET_DepartmentAttReport]   
@STARTDATE DATETIME,  
@ENDDATE DATETIME ,
@Department varchar (20)
AS BEGIN  
--Now generate the dates between two dates using a Common Table Expression and store the values in one temporary table (#TMP_DATES).
--WITH DATERANGE AS  
--(  
--   SELECT DT =DATEADD(DD,0, @STARTDATE)  
--   WHERE DATEADD(DD, 1, @STARTDATE) <= @ENDDATE  
--   UNION ALL  
--   SELECT DATEADD(DD, 1, DT)  
--   FROM DATERANGE  
--   WHERE DATEADD(DD, 1, DT) <= @ENDDATE  
--)  
--SELECT * INTO #TMP_DATES  
--FROM DATERANGE   


--SELECT * FROM AttData WHERE ATTDate 
--	BETWEEN @STARTDATE AND @ENDDATE
 select EmployeeCode ,Name ,Designation, Department ,cast(CheckIN as time(0))as CheckIn ,cast(CheckOut as time(0)) as CheckOut ,ATTDate,AttStatus
 from Emp_Profile p inner join Emp_Register r on p.EmployeeID = r.EmployeeID  join AttData a on p.EmployeeID= a.EmpID
 where  Department = @Department and  ATTDate 
	BETWEEN @STARTDATE AND @ENDDATE
	order by ATTDate;
 end
GO
/****** Object:  StoredProcedure [dbo].[Get_FianlSettelment]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
Create PROCEDURE [dbo].[Get_FianlSettelment]
@session varchar (50),
 @startdate date ,
 @enddate   date   

 

as
 Begin 
  create table #temptable1 (EmpID int ,usedgp int)
  insert into  #temptable1 
  
  SELECT   a.EmpID ,  sum (a.GracePeriod) as usedgp
  from     AttData a
  where    ATTDate 
  BETWEEN  @STARTDATE 
  AND      @ENDDATE
  group by a.EmpID
   
  create table  #temptable ( ID int ,Deduction DECIMAL(16,2))
  insert into   #temptable
  SELECT        t.EmpID , CONVERT(DECIMAL(16,2), (g.TotalGP -  t.usedgp)*1.0/ h.MinutesDeduction)AS Deduction
  from          HrCompanyConfig  h
  join          EmpGraceHours    g   on       g.CompanyID= h.CompanyID 
  join          #temptable1      t   on       g.EmployeeID=t.EmpID

   

   select  p.CompanyID,EmpID,EmpCode ,Name ,Designation, Department 
    ,count(*) AS TotalDays,
    sum(case when AttStatus = 'P' then 1 else 0 end) AS TotalPresent,
    sum(case when AttStatus = 'A' then 1 else 0 end) AS TotalAbsent,
	sum(case when AttStatus = 'L' then 1 else 0 end) AS TotalLeave,
	sum(case when GracePeriod is null then 0 else GracePeriod end) AS GP,
	sum(case when Overtime is null then 0 else Overtime end) AS OT,
	((case when Deduction >0 OR Deduction is null  then 0 else   Deduction end )+sum(case when AttStatus = 'A' then -1 else 0 end)) as Deduction
	,Salary ,
	@session,
	(case when sum((Overtime)*(((Salary/30)/8)/60)) is null then 0 else (sum(Overtime)*(((Salary/30)/8)/60)) end) as OAmount,
	(case when (Deduction*(Salary/30)) is null then 0 else ( ABS((Deduction*(Salary/30)))+(ABS(sum(case when AttStatus = 'A' then 1 else 0 end)*(Salary/30)))) end) as DAmount,
	(Salary+(sum(Overtime)*(((Salary/30)/8)/60))-(case when (Deduction*(Salary/30)) is null then 0 else ( ABS((Deduction*(Salary/30)))+(ABS(sum(case when AttStatus = 'A' then 1 else 0 end)*(Salary/30)))) end)) as TPayable,
	('P') AS DStatus
 from      Emp_Profile   p 
 join      AttData       a on p.EmployeeID = a.EmpID 
 join      EmpGraceHours g on g.EmployeeID = a.EmpID 
 join      #temptable    t on g.EmployeeID = t.ID
 join      Emp_Register  r on p.EmployeeID = r.EmployeeID 

 where    
       ATTDate 
 BETWEEN   @STARTDATE 
 AND       @ENDDATE

 AND r.Status in ( 'Resigned' , 'Resinged' , 'Terminate')
 GROUP BY p.CompanyID, EmpID,EmpCode
, Name
, Designation
, Department ,Deduction,Salary 



drop table #temptable
drop table #temptable1
end


GO
/****** Object:  StoredProcedure [dbo].[Get_FinalSettlement]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[Get_FinalSettlement]
 @createdby varchar (50) ,
 @createdon varchar (50) ,
 @session varchar (50),
 @startdate date  ,
 @enddate   date  ,
 @id int 
 as
 Begin
 set nocount on 
  create table #temptable1 (EmpID int, usedgp int)
  insert into  #temptable1
  SELECT   a.EmpID, sum (a.GracePeriod) as usedgp
  from     AttData a
  where    ATTDate
  BETWEEN  @STARTDATE
  AND      @ENDDATE
  group by a.EmpID
  create table  #temptable ( ID int ,Deduction DECIMAL(16,2))
  insert into   #temptable
  SELECT        t.EmpID, CONVERT(DECIMAL(16,2), (g.TotalGP -  t.usedgp)*1.0/ h.MinutesDeduction)AS Deduction
  from          HrCompanyConfig  h
  join          EmpGraceHours    g   on       g.CompanyID= h.CompanyID
  join          #temptable1      t   on       g.EmployeeID=t.EmpID

   insert into FinalSettlement (CompanyID, EmployeeID, ResignOn, Totaldays, TotalPeresnt, TotalAbsent, TotalLeave, GracePeriod, OverTime, Deduction, SessionName, OAmount, DAmount, TAmount, Status, MStatus, DStatus, HrStatus, FStatus, CreatedBy, CreatedOn, LoanAmount, Fine, ArrearsAmount, BonusAmount)
   select  p.CompanyID, EmpID, @ENDDATE, count(*) AS TotalDays,
    sum(case when AttStatus = 'P' then 1 else 0 end) AS TotalPresent,
    sum(case when AttStatus = 'A' then 1 else 0 end) AS TotalAbsent,
	sum(case when AttStatus = 'L' then 1 else 0 end) AS TotalLeave,
	sum(case when GracePeriod is null then 0 else GracePeriod end) AS GP,
	sum(case when Overtime is null then 0 else Overtime end) AS OT,
	((case when Deduction >0 OR Deduction is null  then 0 else   Deduction end )+sum(case when AttStatus = 'A' then -1 else 0 end)) as Deduction,
	@session,
	(case when sum((Overtime)*(((Salary/30)/8)/60)) is null then 0 else (sum(Overtime)*(((Salary/30)/8)/60)) end) as OAmount,
	(case when (Deduction*(Salary/30)) is null then 0 else ( ABS((Deduction*(Salary/30)))+(ABS(sum(case when AttStatus = 'A' then 1 else 0 end)*(Salary/30)))) end) as DAmount,
	(Salary+(sum(Overtime)*(((Salary/30)/8)/60))-(case when (Deduction*(Salary/30)) is null then 0 else ( ABS((Deduction*(Salary/30)))+(ABS(sum(case when AttStatus = 'A' then 1 else 0 end)*(Salary/30)))) end)) as TPayable,

	'Pending', 'Pending', 'Pending', 'Pending', 'Pending', @createdby, @createdon,
	case when  sum (l.InstallmentAmount) is null then 0 else sum (l.InstallmentAmount)  end, 
	case when  f.Status = 'Approved' then sum ( f.FineAmount) else 0 end,
	case when pa.Status = 'Approved' then sum (pa.ArrearsAmount) else 0 end,
	case when  pb.Status = 'Approved' then sum (pb.BonusAmount) else 0 end
 from      Emp_Profile   p
	 join      AttData       a on p.EmployeeID = a.EmpID
	 join      EmpGraceHours g on g.EmployeeID = a.EmpID
	 join      #temptable    t on g.EmployeeID = t.ID
	 join      Emp_Register  r on p.EmployeeID = r.EmployeeID
left join      FineDetail    f  on p.EmployeeID = f.EmployeeID and f.Status = 'Approved'
left join   LoanDetail l  on p.EmployeeID = l.EmployeeID and l.InstallmentStatus = 'Unpaid'
left join PayrollArrears pa on p.EmployeeID = pa.EmployeeID and pa.Status = 'Approved'
left join PayrollBonuses pb  on p.EmployeeID = pb.EmployeeID and pb.Status = 'Approved'
 where
       ATTDate
 BETWEEN   @STARTDATE
 AND       @ENDDATE
 and p.EmployeeID = @id
 GROUP BY p.CompanyID, EmpID, Deduction, Salary, f.Status , l.EmployeeID, pa.Status , pb.Status
drop table #temptable
   select * from  #temptable1

drop table #temptable1


end
GO
/****** Object:  StoredProcedure [dbo].[Get_reporting_tree]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Get_reporting_tree] @id1 int , @name varchar(50) ,@companyid varchar(50)
as
BEGIN
WITH  subordinate AS (
    SELECT EmployeeID, ReportingTo, 0 AS level FROM Emp_Register WHERE ReportingTo = @id1
    UNION ALL
    SELECT  e.EmployeeID,e.ReportingTo,level + 1 FROM Emp_Register e
	JOIN subordinate s ON e.ReportingTo = s.EmployeeID )
SELECT er.*,ep.*,s.level 
FROM subordinate s JOIN Emp_Register m
ON s.ReportingTo = m.EmployeeID JOIN Emp_Profile ep ON ep.EmployeeID= s.EmployeeID join  Emp_Register er on  ep.EmployeeID= er.EmployeeID 
where ep.Name   like '%'+ @name+'%' and er.CompanyID = @companyid 
 and 
  er.Status !='Terminated'      and er.Status !='Resigned'
order by s.level ASC 

;
END
GO
/****** Object:  StoredProcedure [dbo].[Get_TotalReport]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[Get_TotalReport]
 @startdate date ,
 @enddate   date   

 


AS
 Begin 
  --create table #temptable1 (EmpID int ,usedgp int)
  --insert into  #temptable1 
  
  --SELECT   a.EmpID ,  sum (a.GracePeriod) as usedgp
  --from     AttData a
  --where    ATTDate 
  --BETWEEN  @STARTDATE 
  --AND      @ENDDATE
  --group by a.EmpID
   
  --create table  #temptable ( ID int ,Deduction DECIMAL(16,2))
  --insert into   #temptable
  --SELECT        g.EmployeeID 
  --, CONVERT(DECIMAL(16,2), (g.TotalGP -  t.usedgp)*1.0/ h.MinutesDeduction)AS GPDeduction
  --from          HrCompanyConfig  h
  --join          EmpGraceHours    g   on       g.CompanyID= h.CompanyID 
  --join          #temptable1      t   on       g.EmployeeID=t.EmpID

   
  

   select  EmpID,EmpCode ,Name ,Designation, Department 
    ,count(*) AS TotalDays,
    sum(case when AttStatus in ('P' , 'L') then 1 else 0 end) AS TotalPresent,
    sum(case when AttStatus = 'A' then 1 else 0 end) AS TotalAbsent,
	sum(case when AttStatus = 'LE' then 1 else 0 end) AS TotalLeave,
	sum(GracePeriod) AS GP,
	sum(Overtime) as OT
	--,(case when GPDeduction >0 then 0 else   GPDeduction end )as GPDeduction
 from       Emp_Profile   p 
 join       Emp_Register  r on p.EmployeeID = r.EmployeeID  
 join       AttData       a on p.EmployeeID = a.EmpID 
 join       EmpGraceHours g on p.EmployeeID = g.EmployeeID 
 --join #temptable t on g.EmployeeID =t.ID
 where    
       ATTDate 
 BETWEEN   @STARTDATE 
 AND       @ENDDATE
 AND       r.Status in ( 'Registered','Suspended')
 GROUP BY  EmpID,EmpCode
, Name
, Designation
, Department 
--,Deduction

--drop table #temptable
--drop table #temptable1
end
GO
/****** Object:  StoredProcedure [dbo].[Get_TotalReport_Session]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[Get_TotalReport_Session]
@session varchar (50),
 @startdate date ,
 @enddate   date
as
 Begin
  --create table #temptable1 (EmpID int ,usedgp int)
  --insert into  #temptable1
  --SELECT   a.EmpID ,  sum (a.GracePeriod) as usedgp
  --from     AttData a
  --where    ATTDate
  --BETWEEN  @STARTDATE
  --AND      @ENDDATE
  --group by a.EmpID
  --create table  #temptable ( ID int ,Deduction DECIMAL(16,2))
  --insert into   #temptable
  --SELECT        t.EmpID , CONVERT(DECIMAL(16,2), (g.TotalGP -  t.usedgp)*1.0/ h.MinutesDeduction)AS Deduction
  --from          HrCompanyConfig  h
  --join          EmpGraceHours    g   on       g.CompanyID= h.CompanyID
  --join          #temptable1      t   on       g.EmployeeID=t.EmpID
 
   select  p.CompanyID,p.EmployeeID,p.Employee_Code ,p.Name ,r.Designation, r.Department
    ,count(*) AS TotalDays,
    sum(case when AttStatus in ( 'P', 'L') then 1 else 0 end) AS TotalPresent,
    sum(case when AttStatus = 'A' then 1 else 0 end) AS TotalAbsent,
	sum(case when AttStatus = 'LE' then 1 else 0 end) AS TotalLeave,
	sum(case when GracePeriod is null then 0 else GracePeriod end) AS GP,
	sum(case when Overtime is null then 0 else Overtime end) AS OT,
	--((case when Deduction >0 OR Deduction is null  then 0 else   Deduction end )+sum(case when AttStatus = 'A' then -1 else 0 end)) 
	0 as GPDeduction,
	Salary ,
	@session,
	--(case when sum((Overtime)*(((Salary/30)/8)/60)) is null then 0 else (sum(Overtime)*(((Salary/30)/8)/60)) end) 
	 0 as OAmount,
	--(case when (Deduction*(Salary/30)) =0 then 0 else  0 -- ( ABS((Deduction*(Salary/30)))+(ABS(sum(case when AttStatus = 'A' then 1 else 0 end)*(Salary/30)))) end) 
	--end )
	0 as DAmount,

	--(Salary+(sum(Overtime)*(((Salary/30)/8)/60))-(case when (Deduction*(Salary/30)) is null then 0 else ( ABS((Deduction*(Salary/30)))+(ABS(sum(case when AttStatus = 'A' then 1 else 0 end)*(Salary/30)))) end)) as TPayable,
	
	case when cast (r.JoiningDate as Date)  >@STARTDATE then  Salary/ 30 * (  30   -   datediff (day  ,(SELECT DATEFROMPARTS(YEAR(GETDATE()), MONTH(GETDATE()), 1)),r.JoiningDate) )
	     when cast (r.JoiningDate as Date)  <@STARTDATE then  Salary 
		 else Salary 
		 end as TPayable,
		('P') AS DStatus
		--,r.JoiningDate
 from      Emp_Profile   p
 join      AttData       a on p.EmployeeID = a.EmpID
 --join      EmpGraceHours g on g.EmployeeID = a.EmpID
-- join      #temptable    t on g.EmployeeID = t.ID
 join      Emp_Register  r on p.EmployeeID = r.EmployeeID
 where
       ATTDate
 BETWEEN   @STARTDATE 
 AND       @ENDDATE
 and       r.status = 'Registered'
 --in( 'Registered','Suspended')
 GROUP BY p.CompanyID,p.EmployeeID,p.Employee_Code ,p.Name 
 ,r.Designation, r.Department
,Salary
,r.JoiningDate
--drop table #temptable
--drop table #temptable1
end



--SELECT DATEFROMPARTS(YEAR(GETDATE()), MONTH(GETDATE()), 1)

--select datediff (day ,r.JoiningDate ,(select (substring (convert (varchar(10),getdate (),120) ,1,10 )))) , JoiningDate,EmployeeID
--from Emp_Register r
--where r.JoiningDate > '2022-12-20'
GO
/****** Object:  StoredProcedure [dbo].[Get_TotalReport_Session_full Salary]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create PROCEDURE [dbo].[Get_TotalReport_Session_full Salary]
@session varchar (50),
 @startdate date ,
 @enddate   date
as
 Begin
  create table #temptable1 (EmpID int ,usedgp int)
  insert into  #temptable1
  SELECT   a.EmpID ,  sum (a.GracePeriod) as usedgp
  from     AttData a
  where    ATTDate
  BETWEEN  @STARTDATE
  AND      @ENDDATE
  group by a.EmpID
  create table  #temptable ( ID int ,Deduction DECIMAL(16,2))
  insert into   #temptable
  SELECT        t.EmpID , CONVERT(DECIMAL(16,2), (g.TotalGP -  t.usedgp)*1.0/ h.MinutesDeduction)AS Deduction
  from          HrCompanyConfig  h
  join          EmpGraceHours    g   on       g.CompanyID= h.CompanyID
  join          #temptable1      t   on       g.EmployeeID=t.EmpID
   select  p.CompanyID,EmpID,EmpCode ,Name ,Designation, Department
    ,count(*) AS TotalDays,
    sum(case when AttStatus = 'P' then 1 else 0 end) AS TotalPresent,
    sum(case when AttStatus = 'A' then 1 else 0 end) AS TotalAbsent,
	sum(case when AttStatus = 'L' then 1 else 0 end) AS TotalLeave,
	sum(case when GracePeriod is null then 0 else GracePeriod end) AS GP,
	sum(case when Overtime is null then 0 else Overtime end) AS OT,
	((case when Deduction >0 OR Deduction is null  then 0 else   Deduction end )+sum(case when AttStatus = 'A' then -1 else 0 end)) as Deduction
	,Salary ,
	@session,
	(case when sum((Overtime)*(((Salary/30)/8)/60)) is null then 0 else (sum(Overtime)*(((Salary/30)/8)/60)) end) as OAmount,
	(case when (Deduction*(Salary/30)) =0 then 0 else  0 -- ( ABS((Deduction*(Salary/30)))+(ABS(sum(case when AttStatus = 'A' then 1 else 0 end)*(Salary/30)))) end) 
	end )as DAmount,

	(Salary+(sum(Overtime)*(((Salary/30)/8)/60))-(case when (Deduction*(Salary/30)) is null then 0 else ( ABS((Deduction*(Salary/30)))+(ABS(sum(case when AttStatus = 'A' then 1 else 0 end)*(Salary/30)))) end)) as TPayable,
	('P') AS DStatus
 from      Emp_Profile   p
 join      AttData       a on p.EmployeeID = a.EmpID
 join      EmpGraceHours g on g.EmployeeID = a.EmpID
 join      #temptable    t on g.EmployeeID = t.ID
 join      Emp_Register  r on p.EmployeeID = r.EmployeeID
 where
       ATTDate
 BETWEEN   @STARTDATE
 AND       @ENDDATE
 and       r.status in( 'Registerd','Suspended')
 GROUP BY p.CompanyID, EmpID,EmpCode
, Name
, Designation
, Department ,Deduction,Salary
drop table #temptable
drop table #temptable1
end






GO
/****** Object:  StoredProcedure [dbo].[Get_TotalReport_Sessioncheck]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create PROCEDURE [dbo].[Get_TotalReport_Sessioncheck]
@session varchar (50),
 @startdate date ,
 @enddate   date
as
 Begin
  create table #temptable1 (EmpID int ,usedgp int)
  insert into  #temptable1
  SELECT   a.EmpID ,  sum (a.GracePeriod) as usedgp
  from     AttData a
  where    ATTDate
  BETWEEN   @STARTDATE
  AND       @ENDDATE
  group by a.EmpID
  create table  #temptable ( ID int ,Deduction DECIMAL(16,2))
  insert into   #temptable
  SELECT        t.EmpID , CONVERT(DECIMAL(16,2), (g.TotalGP -  t.usedgp)- h.MinutesDeduction)AS Deduction
  from          HrCompanyConfig  h
  join          EmpGraceHours    g   on       g.CompanyID= h.CompanyID
  join          #temptable1      t   on       g.EmployeeID=t.EmpID


   select  p.CompanyID,EmpID,r.EmployeeCode ,Name ,Designation, Department
    ,count(*) AS TotalDays,
    sum(case when AttStatus = 'P' then 1 else 0 end) AS TotalPresent,
    sum(case when AttStatus = 'A' then 1 else 0 end) AS TotalAbsent,
	sum(case when AttStatus = 'LE' then 1 else 0 end) AS TotalLeave,
	sum(case when GracePeriod is null then 0 else GracePeriod end) AS GP,
	sum(case when Overtime is null then 0 else Overtime end) AS OT,
	((case when Deduction > 0 OR Deduction is null  then 0 else   Deduction end )+sum(case when AttStatus = 'A' then -1 else 0 end)) as Deduction
	,Salary ,
	@session,
	(case when sum((Overtime)*(((Salary/30)/8)/60)) is null then 0 else (sum(Overtime)*(((Salary/30)/8)/60)) end) as OAmount,
	(case when (Deduction*(Salary/30)) <= 0 then 0 else ( ABS((Deduction*(Salary/30)))+(ABS(sum(case when AttStatus = 'A' then 1 else 0 end)*(Salary/30)))) end) as DAmount,
	(Salary+(sum(Overtime)*(((Salary/30)/8)/60))-(case when (Deduction*(Salary/30)) is null then 0 else ( ABS((Deduction*(Salary/30)))+(ABS(sum(case when AttStatus = 'A' then 1 else 0 end)*(Salary/30)))) end)) as TPayable,
	('P') AS DStatus
 from      Emp_Profile   p
 join      AttData       a on p.EmployeeID = a.EmpID
 join      EmpGraceHours g on g.EmployeeID = a.EmpID
 join      #temptable    t on g.EmployeeID = t.ID
 join      Emp_Register  r on p.EmployeeID = r.EmployeeID
 where
       ATTDate
 BETWEEN   @STARTDATE
 AND       @ENDDATE
 AND r.Status in ( 'Registered' , 'Suspended')
 GROUP BY p.CompanyID, EmpID,EmpCode
, Name
, Designation
, Department ,Deduction,Salary,r.EmployeeCode
drop table #temptable
drop table #temptable1
end
GO
/****** Object:  StoredProcedure [dbo].[GetDailyAtt]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO


CREATE procedure [dbo].[GetDailyAtt] 

as 
begin
set nocount on

declare @todaydate datetime = getdate()
 select EmpID ,Name ,Designation, Department , cast(CheckIN as time(0))as CheckIn ,cast(CheckOut as time(0)) as CheckOut ,ATTDate,AttStatus
 from Emp_Profile p inner join Emp_Register r on p.EmployeeID = r.EmployeeID  join AttData a on p.EmployeeID= a.EmpID
 where year(ATTDate)  = year(@todaydate) and month(ATTDate) = month(@todaydate) and day(ATTDate) = day(@todaydate)

  select count(*) as 'TotalPresent'
 from Emp_Profile p inner join Emp_Register r on p.EmployeeID = r.EmployeeID  join AttData a on p.EmployeeID= a.EmpID
 where  year(ATTDate)  = year(@todaydate) and month(ATTDate) = month(@todaydate) and day(ATTDate) = day(@todaydate) and AttStatus = 'P'

   select count(*) as 'TotalAbsent'
 from Emp_Profile p inner join Emp_Register r on p.EmployeeID = r.EmployeeID  join AttData a on p.EmployeeID= a.EmpID
 where year(ATTDate)  = year(@todaydate) and month(ATTDate) = month(@todaydate) and day(ATTDate) = day(@todaydate) and AttStatus = 'A'
   select count(*) as 'TotalLeave'
 from Emp_Profile p inner join Emp_Register r on p.EmployeeID = r.EmployeeID  join AttData a on p.EmployeeID= a.EmpID
where year(ATTDate)  = year(@todaydate) and month(ATTDate) = month(@todaydate) and day(ATTDate) = day(@todaydate) and AttStatus = 'L'
   select count(*) as 'NotMarked'
 from Emp_Profile p inner join Emp_Register r on p.EmployeeID = r.EmployeeID  join AttData a on p.EmployeeID= a.EmpID
 where year(ATTDate)  = year(@todaydate) and month(ATTDate) = month(@todaydate) and day(ATTDate) = day(@todaydate) and AttStatus = NULL

 end


GO
/****** Object:  StoredProcedure [dbo].[GetDateList]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[GetDateList]
 @STARTDATE DATE,  
@ENDDATE DATE  
AS BEGIN  
set nocount on 
--Now generate the dates between two dates using a Common Table Expression and store the values in one temporary table (#TMP_DATES).
;WITH DATERANGE AS  
(  
   SELECT DT =DATEADD(DD,0, @STARTDATE)  
   WHERE DATEADD(DD, 1, @STARTDATE) <= @ENDDATE  
   UNION ALL  
   SELECT DATEADD(DD, 1, DT)  
   FROM DATERANGE  
   WHERE DATEADD(DD, 1, DT) <= @ENDDATE  
)  
SELECT * INTO  #TMP_DATES  
FROM DATERANGE 
select * from #TMP_DATES
end
GO
/****** Object:  StoredProcedure [dbo].[GetEmpAttReport]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[GetEmpAttReport]   
@STARTDATE DATETIME,  
@ENDDATE DATETIME ,
@EmpID varchar (20)
AS BEGIN  

select EmpID ,Name ,Designation, Department  ,ATTDate,cast(CheckIN as time(0))as CheckIn ,cast(CheckOut as time(0)) as CheckOut ,AttStatus
 from Emp_Profile p inner join Emp_Register r on p.EmployeeID = r.EmployeeID  join AttData a on p.EmployeeID= a.EmpID
 where  EmpID = @EmpID and  ATTDate 
	BETWEEN @STARTDATE AND @ENDDATE
	order by ATTDate;
with cte as 
(select EmpID ,Name ,Designation, Department  ,ATTDate,AttStatus
 from Emp_Profile p inner join Emp_Register r on p.EmployeeID = r.EmployeeID  join AttData a on p.EmployeeID= a.EmpID
 where  EmpID = @EmpID and  ATTDate 
	BETWEEN @STARTDATE AND @ENDDATE)
select * into #tmpresult
from cte
  select  count(*) as 'TotalPresent' 
 from #tmpresult
  where AttStatus = 'P'
  
	select  count(*) as 'TotalAbsent' 
 from #tmpresult
  where AttStatus = 'A'
  
	select  count(*) as 'TotalLeaves' 
 from #tmpresult
  where AttStatus = 'L'

 end


GO
/****** Object:  StoredProcedure [dbo].[GetEmployeeHierarchy]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[GetEmployeeHierarchy] (@EmployeeID INT, @ExecuteInsert BIT)
AS
BEGIN
	DECLARE @level INT = 0

CREATE TABLE #temp (EmployeeID INT, ReportingTo INT, [level] INT)

INSERT INTO #temp
SELECT EmployeeID, ReportingTo, @level
FROM Emp_Register
WHERE ReportingTo = @EmployeeID

WHILE @@ROWCOUNT > 0
BEGIN
    SET @level = @level + 1

		IF @ExecuteInsert = 0
			BREAK;

    INSERT INTO #temp
    SELECT e.EmployeeID, e.ReportingTo, @level
    FROM Emp_Register e
    INNER JOIN #temp t ON e.ReportingTo = t.EmployeeID
    WHERE t.[level] = @level - 1
END

SELECT er.*, ep.*, t.[level]
FROM #temp t
INNER JOIN Emp_Register er ON t.EmployeeID = er.EmployeeID
INNER JOIN Emp_Profile ep ON t.EmployeeID = ep.EmployeeID
WHERE er.Status != 'Terminated' AND er.Status != 'Resigned'
ORDER BY t.[level] ASC

DROP TABLE #temp
end
GO
/****** Object:  StoredProcedure [dbo].[GetMonthltAttReport]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[GetMonthltAttReport]   
@STARTDATE DATETIME,  
@ENDDATE DATETIME  
AS BEGIN  
--Now generate the dates between two dates using a Common Table Expression and store the values in one temporary table (#TMP_DATES).
WITH DATERANGE AS  
(  
   SELECT DT =DATEADD(DD,0, @STARTDATE)  
   WHERE DATEADD(DD, 1, @STARTDATE) <= @ENDDATE  
   UNION ALL  
   SELECT DATEADD(DD, 1, DT)  
   FROM DATERANGE  
   WHERE DATEADD(DD, 1, DT) <= @ENDDATE  
)  
SELECT * INTO #TMP_DATES  
FROM DATERANGE   


dECLARE @COLUMN VARCHAR(MAX)  
SELECT @COLUMN=ISNULL(@COLUMN+',','')+ '['+ CAST(CONVERT(DATE , DT) AS VARCHAR) + ']' FROM #TMP_DATES

DECLARE @Columns2 VARCHAR(MAX) 
sET @Columns2 = SUBSTRING((SELECT DISTINCT ',ISNULL(['+ CAST(CONVERT(DATE , DT) as varchar )+'],''-'') AS ['+CAST(CONVERT(DATE , DT) as varchar )+']' 
FROM #TMP_DATES GROUP BY dt FOR XML PATH('')),2,8000) 

-- ,' + @Columns2 +'

DECLARE @QUERY VARCHAR(MAX)  
SET @QUERY = 'SELECT EmpID,Name,Designation,Department ,' + @Columns2 +' FROM   
(  
 select  EmpID,Name,Designation,Department  ,ATTDate,AttStatus
  from   Emp_Profile p inner join Emp_Register r on p.EmployeeID = r.EmployeeID  join AttData a on p.EmployeeID= a.EmpID ) X  
PIVOT   
(  
MIN([AttStatus])  
FOR [AttDate] IN (' + @COLUMN + ')  
) P   
WHERE ISNULL(NAME,'''')<>''''  
'  
  
EXEC (@QUERY)  
--Drop the temporary table.
DROP TABLE #TMP_DATES  
  
END 
GO
/****** Object:  StoredProcedure [dbo].[GetMonthltAttReport_filterwise]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[GetMonthltAttReport_filterwise]   
@STARTDATE DATETIME,  
@ENDDATE DATETIME 
,@dep   varchar (30),
@design varchar(30)
AS BEGIN  
--Now generate the dates between two dates using a Common Table Expression and store the values in one temporary table (#TMP_DATES).
WITH DATERANGE AS  
(  
   SELECT DT =DATEADD(DD,0, @STARTDATE)  
   WHERE DATEADD(DD, 1, @STARTDATE) <= @ENDDATE  
   UNION ALL  
   SELECT DATEADD(DD, 1, DT)  
   FROM DATERANGE  
   WHERE DATEADD(DD, 1, DT) <= @ENDDATE  
)  
SELECT * INTO #TMP_DATES  
FROM DATERANGE   
dECLARE @COLUMN VARCHAR(MAX)  
SELECT @COLUMN=ISNULL(@COLUMN+',','')+ '['+ CAST(CONVERT(DATE , DT) AS VARCHAR) + ']' FROM #TMP_DATES
DECLARE @Columns2 VARCHAR(MAX) 
sET @Columns2 = SUBSTRING((SELECT DISTINCT ',ISNULL(['+ CAST(CONVERT(DATE , DT) as varchar )+'],''N/A'') AS ['+CAST(CONVERT(DATE , DT) as varchar )+']' 
FROM #TMP_DATES GROUP BY dt FOR XML PATH('')),2,8000) 
-- ,' + @Columns2 +'
DECLARE @QUERY VARCHAR(MAX)  
SET @QUERY = ' if ( '''+ @dep +''' is not null And '''+ @design +''' is not null)
begin
SELECT EmpID,Name,Designation,Department ,' + @Columns2 +' FROM   
(  
 select  EmpID,Name,Designation,Department  ,ATTDate,AttStatus
  from   Emp_Profile p inner join Emp_Register r on p.EmployeeID = r.EmployeeID  join AttData a on p.EmployeeID= a.EmpID 
  where  Department = '''+ @dep +''' and Designation = '''+ @design +''') X  
PIVOT   
(  
MIN([AttStatus])  
FOR [AttDate] IN (' + @COLUMN + ')  
) P   
WHERE ISNULL(NAME,'''')<>''''  
end'  
  
EXEC (@QUERY)  
--Drop the temporary table.
DROP TABLE #TMP_DATES  
  
END 

GO
/****** Object:  StoredProcedure [dbo].[GetMonthlyOvertimeReport]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[GetMonthlyOvertimeReport] 
@STARTDATE DATETIME,  
@ENDDATE DATETIME,
@dept varchar (100)
AS BEGIN  
--Now generate the dates between two dates using a Common Table Expression and store the values in one temporary table (#TMP_DATES).
WITH DATERANGE AS  
(  
   SELECT DT =DATEADD(DD,0, @STARTDATE)  
   WHERE DATEADD(DD, 1, @STARTDATE) <= @ENDDATE  
   UNION ALL  
   SELECT DATEADD(DD, 1, DT)  
   FROM DATERANGE  
   WHERE DATEADD(DD, 1, DT) <= @ENDDATE  
)  
SELECT * INTO #TMP_DATES  
FROM DATERANGE 




DECLARE @COLUMN VARCHAR(MAX)  
SELECT @COLUMN=ISNULL(@COLUMN+',','')+ '['+ CAST(CONVERT(DATE , DT) AS VARCHAR) + ']' FROM #TMP_DATES

DECLARE @Columns2 VARCHAR(MAX) 
SET @Columns2 = SUBSTRING((SELECT DISTINCT ',ISNULL(['+ CAST(CONVERT(DATE , DT) as varchar )+'],''-'') AS ['+CAST(CONVERT(DATE , DT) as varchar )+']' 
FROM #TMP_DATES GROUP BY dt FOR XML PATH('')),2,8000) 

-- ,' + @Columns2 +'

DECLARE @QUERY VARCHAR(MAX)  
SET @QUERY = 'SELECT EmpID,EmpCode,Name,Designation,Department ,' + @Columns2 +' FROM   
(  
 select  EmpID,EmpCode,Name,Designation,r.Department  ,ATTDate,Overtime
  from       Emp_Profile  p 
  inner join Emp_Register r on p.EmployeeID = r.EmployeeID  
  join       AttData      a on p.EmployeeID = a.EmpID 
  ) X  
PIVOT   
(  
sum([Overtime])  
FOR [AttDate] IN (' + @COLUMN + ')  
) P   
WHERE ISNULL(NAME,'''')<>'''' AND Department = ''' + @dept + '''

'  
  
EXEC (@QUERY)  
--Drop the temporary table.
DROP TABLE #TMP_DATES  
  
END 
GO
/****** Object:  StoredProcedure [dbo].[Hiring_Report]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Hiring_Report]
@date date,
@date1 date ,
@Dep varchar (100) 
as begin 

select p.Name , p.FatherHusband ,r.EmployeeCode , r.Department , r.JoiningDate , r.Status , r.JobStatus from Emp_Register r 
join Emp_profile p on r.EmployeeID = p.EmployeeID
where [JoiningDate] between   @date  and @date1
and Department =  case when @Dep = '' then Department else @Dep end --'SA Marketing'   --@Dep
--and Status =  case when @status = '' then Status else @status end 
end
GO
/****** Object:  StoredProcedure [dbo].[Loan_Advances_Report]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE procedure [dbo].[Loan_Advances_Report]
@date date,
@date1 date ,
@Dep varchar (100) ,
@type varchar (50),
@ReqStatus varchar (50)


as begin 

select l.LoanId ,p.Name ,r.Department , r.EmployeeCode,L.LoanReason, l.LoanAmount , l.LoanInstallments ,l.LoanType,l.ReqStatus,l.ApplyDate 
--case when ld.InstallmentStatus = 'Paid' then sum (ld.InstallmentAmount) end as PaidAmount , case when ld.InstallmentStatus = 'Pending' then sum (ld.InstallmentAmount) end as PendingAmount
--sum (ld.InstallmentAmount)  PaidAmount, sum (ld.InstallmentAmount) PendingAmount 
from LoanRequisition l 
join Emp_profile p on l.EmployeeID = p.EmployeeID
join Emp_Register r on l.EmployeeID = r.EmployeeID
--inner join Loandetail ld on l.LoanId = ld.LoanId --and ld.InstallmentStatus = 'Paid'
--join Loandetail lt on l.LoanId = lt.LoanId and ld.InstallmentStatus = 'Pending'
where ApplyDate between   @date  and @date1
and l.LoanType = case when @type = '' then l.LoanType else @type end 
and l.ReqStatus = case when @ReqStatus = '' then l.ReqStatus else @ReqStatus end 
and r.Department = case when @Dep = '' then r.Department else @Dep end 
--Group by    l.LoanId , p.Name ,r.Department , L.LoanReason, l.LoanAmount , l.LoanInstallments ,l.LoanType,l.ReqStatus,l.ApplyDate --, ld.InstallmentStatus
end
GO
/****** Object:  StoredProcedure [dbo].[Remove_suspension]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create procedure [dbo].[Remove_suspension]
as begin 

Update Emp_Register
set Status  = 'Registered'
where Status = 'Suspended'
and SuspensionEnd   = (select (substring (convert (varchar(10),getdate (),120) ,1,10 )))
end
GO
/****** Object:  StoredProcedure [dbo].[Salary_DistributionReport]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Salary_DistributionReport]


as begin 
;with cte as (
SELECT 
    p.SessionName,
	SUM (PayableSalary) as TotalPayable

	 ,(case when p.[ReceivedThrough] is null     then sum (PayableSalary) else 0 end )      as Pending,
	 (case when p.[ReceivedThrough] is not null then sum (PayableSalary) else 0 end )     as Paid

FROM [dbo].[Payroll_Distribution] p
GROUP BY p.SessionName,[ReceivedThrough]
)
select SessionName , SUM (TotalPayable) TotalPayable , SUM (Pending) Pending , SUM (Paid) Paid from cte
group by SessionName
order by SessionName desc
end 
GO
/****** Object:  StoredProcedure [dbo].[Salary_Report_DepartmentWise]    Script Date: Saturday, 11-Mar-2023 11:58:23 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
​
CREATE Procedure [dbo].[Salary_Report_DepartmentWise]
@Sessionname varchar (50),
@compID varchar (50)
as begin
set nocount on
SELECT
 [Department] ,[SessionName]
      ,sum ([Salary]                 )as [Salary]
      ,sum([OAmount]                 )as [OAmount]
      ,sum ([DAmount]                )as [DAmount]
      ,sum ([TAmount]                )as [TAmount]
      ,sum ([InstallmentAmount]      )as [InstallmentAmount]
      ,sum([Fine]                    )as [Fine]
      ,sum ([DuesAmount]             )as [DuesAmount]
      ,sum([ArrearsAmount]           )as[ArrearsAmount]
	  ,sum ([BonusAmount]            )as[BonusAmount]
	  ,sum ([AllowanceAmount]        )as [AllowanceAmount]
      ,sum ([PayableSalary]          )as [PayableSalary]
	  ,sum ( [AdvanceAmount]         )as [AdvanceAmount]
      ,sum ([FuelAmount]             )as [FuelAmount]
      ,sum ([FuelReceivable]         )as [FuelReceivable]
  FROM     [Payroll_Distribution]
  where    SessionName = @Sessionname
  and      CompanyID = @compID
  group by Department , [SessionName]
  end
​
​
 
GO
USE [master]
GO
ALTER DATABASE [HRMS_SAG_REPLICA] SET  READ_WRITE 
GO
