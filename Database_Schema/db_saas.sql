USE [master]
GO
/****** Object:  Database [db_sass]    Script Date: Saturday, 11-Mar-2023 11:57:17 AM ******/
CREATE DATABASE [db_sass]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'db_sass', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\db_sass.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'db_sass_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\db_sass_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
 WITH CATALOG_COLLATION = DATABASE_DEFAULT
GO
ALTER DATABASE [db_sass] SET COMPATIBILITY_LEVEL = 140
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [db_sass].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [db_sass] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [db_sass] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [db_sass] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [db_sass] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [db_sass] SET ARITHABORT OFF 
GO
ALTER DATABASE [db_sass] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [db_sass] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [db_sass] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [db_sass] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [db_sass] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [db_sass] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [db_sass] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [db_sass] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [db_sass] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [db_sass] SET  DISABLE_BROKER 
GO
ALTER DATABASE [db_sass] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [db_sass] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [db_sass] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [db_sass] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [db_sass] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [db_sass] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [db_sass] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [db_sass] SET RECOVERY SIMPLE 
GO
ALTER DATABASE [db_sass] SET  MULTI_USER 
GO
ALTER DATABASE [db_sass] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [db_sass] SET DB_CHAINING OFF 
GO
ALTER DATABASE [db_sass] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [db_sass] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [db_sass] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [db_sass] SET ACCELERATED_DATABASE_RECOVERY = OFF  
GO
EXEC sys.sp_db_vardecimal_storage_format N'db_sass', N'ON'
GO
ALTER DATABASE [db_sass] SET QUERY_STORE = OFF
GO
USE [db_sass]
GO
/****** Object:  User [SASystems]    Script Date: Saturday, 11-Mar-2023 11:57:18 AM ******/
CREATE USER [SASystems] WITHOUT LOGIN WITH DEFAULT_SCHEMA=[dbo]
GO
ALTER ROLE [db_datareader] ADD MEMBER [SASystems]
GO
/****** Object:  Table [dbo].[Activity_Log]    Script Date: Saturday, 11-Mar-2023 11:57:18 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Activity_Log](
	[LogId] [int] IDENTITY(1,1) NOT NULL,
	[CompanyId] [varchar](50) NULL,
	[UserEmail] [varchar](100) NULL,
	[EmployeeID] [int] NULL,
	[EmployeeName] [varchar](50) NULL,
	[EventStatus] [varchar](50) NULL,
	[Description] [varchar](max) NULL,
	[ActivityTime] [varchar](255) NULL,
PRIMARY KEY CLUSTERED 
(
	[LogId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tb_company_locations]    Script Date: Saturday, 11-Mar-2023 11:57:18 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tb_company_locations](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[location_name] [varchar](255) NULL,
	[location_address] [varchar](255) NULL,
	[created_by] [varchar](255) NULL,
	[created_time] [varchar](255) NULL,
	[company_id] [varchar](255) NULL,
	[head_office] [varchar](20) NULL,
	[l_status] [varchar](10) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tb_company_roles]    Script Date: Saturday, 11-Mar-2023 11:57:18 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tb_company_roles](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[company_name] [varchar](255) NULL,
	[company_id] [varchar](255) NULL,
	[permission_module] [varchar](255) NULL,
	[module_status] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tb_conversations]    Script Date: Saturday, 11-Mar-2023 11:57:18 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tb_conversations](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_one] [varchar](255) NULL,
	[user_two] [varchar](255) NULL,
	[con_date] [varchar](255) NULL,
	[CompanyID] [varchar](255) NULL,
	[user_one_id] [int] NULL,
	[user_two_id] [int] NULL,
 CONSTRAINT [PK__tb_conve__3213E83FFF39868A] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tb_create_company]    Script Date: Saturday, 11-Mar-2023 11:57:18 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tb_create_company](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[company_name] [varchar](255) NULL,
	[license_id] [varchar](255) NULL,
	[phone_number] [varchar](255) NULL,
	[company_email] [varchar](255) NULL,
	[company_link] [varchar](255) NULL,
	[company_address] [varchar](255) NULL,
	[city] [varchar](255) NULL,
	[country] [varchar](255) NULL,
	[company_logo] [varchar](255) NULL,
	[created_at] [varchar](255) NULL,
	[company_id] [varchar](255) NULL,
	[c_status] [varchar](20) NULL,
	[company_prefix] [varchar](3) NULL,
 CONSTRAINT [PK__tb_creat__3213E83F44DB174E] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tb_department]    Script Date: Saturday, 11-Mar-2023 11:57:18 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tb_department](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[department_name] [varchar](255) NULL,
	[created_by] [varchar](50) NULL,
	[created_time] [varchar](50) NULL,
	[company_id] [varchar](50) NULL,
	[dd_status] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tb_designation]    Script Date: Saturday, 11-Mar-2023 11:57:18 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tb_designation](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[designation_name] [varchar](255) NULL,
	[created_by] [varchar](50) NULL,
	[created_time] [varchar](50) NULL,
	[company_id] [varchar](50) NULL,
	[d_status] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tb_faqs]    Script Date: Saturday, 11-Mar-2023 11:57:18 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tb_faqs](
	[faqId] [int] IDENTITY(1,1) NOT NULL,
	[Catagory] [varchar](100) NULL,
	[Question] [varchar](max) NULL,
	[Answer] [varchar](max) NULL,
	[Link] [varchar](max) NULL,
PRIMARY KEY CLUSTERED 
(
	[faqId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tb_messages]    Script Date: Saturday, 11-Mar-2023 11:57:18 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tb_messages](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_from] [varchar](255) NULL,
	[user_to] [varchar](255) NULL,
	[con_id] [varchar](255) NULL,
	[message] [text] NULL,
	[status] [int] NULL,
	[m_date] [varchar](max) NULL,
	[CompanyID] [varchar](255) NULL,
	[user_from_id] [int] NULL,
	[user_to_id] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tb_other_Permissions]    Script Date: Saturday, 11-Mar-2023 11:57:18 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tb_other_Permissions](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[company_id] [varchar](255) NULL,
	[cache_value] [varchar](50) NULL,
	[created_on] [nchar](10) NULL,
 CONSTRAINT [PK_tb_other_Permissions] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tb_roles_permissions]    Script Date: Saturday, 11-Mar-2023 11:57:18 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tb_roles_permissions](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[user_id] [int] NULL,
	[user_email] [varchar](100) NULL,
	[hr_read] [varchar](10) NULL,
	[hr_write] [varchar](10) NULL,
	[hr_restricted] [varchar](10) NULL,
	[hr_attendance] [varchar](10) NULL,
	[company_id] [varchar](255) NULL,
	[hr_superadmin] [varchar](50) NULL,
	[hr_overall] [varchar](50) NULL,
	[payroll_read] [varchar](50) NULL,
	[payroll_write] [varchar](50) NULL,
	[payroll_restricted] [varchar](50) NULL,
	[payroll_superadmin] [varchar](50) NULL,
	[payroll_overall] [varchar](50) NULL,
	[accounts_read] [varchar](50) NULL,
	[accounts_write] [varchar](50) NULL,
	[accounts_overall] [varchar](50) NULL,
	[accounts_superadmin] [varchar](50) NULL,
	[store_read] [varchar](50) NULL,
	[store_write] [varchar](50) NULL,
	[store_overall] [varchar](50) NULL,
	[audit_superadmin] [varchar](50) NULL,
 CONSTRAINT [PK__tb_hr_ac__3213E83F863472BE] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tb_users]    Script Date: Saturday, 11-Mar-2023 11:57:18 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tb_users](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[first_name] [varchar](255) NULL,
	[last_name] [varchar](255) NULL,
	[emp_code] [varchar](255) NULL,
	[username] [varchar](255) NULL,
	[user_password] [varchar](255) NULL,
	[ofc_location] [varchar](255) NULL,
	[gender] [varchar](255) NULL,
	[user_address] [varchar](255) NULL,
	[created_by] [varchar](255) NULL,
	[created_time] [varchar](255) NULL,
	[updated_by] [varchar](255) NULL,
	[updated_time] [varchar](255) NULL,
	[email] [varchar](255) NULL,
	[user_role] [varchar](50) NULL,
	[company_id] [varchar](255) NULL,
	[u_status] [varchar](50) NULL,
	[department] [varchar](50) NULL,
	[tour_status] [varchar](10) NULL,
	[photo] [varchar](255) NULL,
	[update_sender] [varchar](100) NULL,
	[UserType] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[tb_other_Permissions] ADD  CONSTRAINT [DF_tb_other_Permissions_created_on]  DEFAULT (getdate()) FOR [created_on]
GO
ALTER TABLE [dbo].[tb_roles_permissions] ADD  CONSTRAINT [DF_tb_roles_permissions_hr_attendance]  DEFAULT ((0)) FOR [hr_attendance]
GO
USE [master]
GO
ALTER DATABASE [db_sass] SET  READ_WRITE 
GO
