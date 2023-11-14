USE [master]
GO
/****** Object:  Database [Account_Finance]    Script Date: Saturday, 11-Mar-2023 11:55:42 AM ******/
CREATE DATABASE [Account_Finance]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'Account_Finance', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\Account_Finance.mdf' , SIZE = 139264KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'Account_Finance_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\Account_Finance_log.ldf' , SIZE = 139264KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
 WITH CATALOG_COLLATION = DATABASE_DEFAULT
GO
ALTER DATABASE [Account_Finance] SET COMPATIBILITY_LEVEL = 140
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [Account_Finance].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [Account_Finance] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [Account_Finance] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [Account_Finance] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [Account_Finance] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [Account_Finance] SET ARITHABORT OFF 
GO
ALTER DATABASE [Account_Finance] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [Account_Finance] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [Account_Finance] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [Account_Finance] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [Account_Finance] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [Account_Finance] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [Account_Finance] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [Account_Finance] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [Account_Finance] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [Account_Finance] SET  DISABLE_BROKER 
GO
ALTER DATABASE [Account_Finance] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [Account_Finance] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [Account_Finance] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [Account_Finance] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [Account_Finance] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [Account_Finance] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [Account_Finance] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [Account_Finance] SET RECOVERY SIMPLE 
GO
ALTER DATABASE [Account_Finance] SET  MULTI_USER 
GO
ALTER DATABASE [Account_Finance] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [Account_Finance] SET DB_CHAINING OFF 
GO
ALTER DATABASE [Account_Finance] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [Account_Finance] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [Account_Finance] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [Account_Finance] SET ACCELERATED_DATABASE_RECOVERY = OFF  
GO
EXEC sys.sp_db_vardecimal_storage_format N'Account_Finance', N'ON'
GO
ALTER DATABASE [Account_Finance] SET QUERY_STORE = OFF
GO
USE [Account_Finance]
GO
/****** Object:  User [SASystems]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
CREATE USER [SASystems] WITHOUT LOGIN WITH DEFAULT_SCHEMA=[dbo]
GO
ALTER ROLE [db_datareader] ADD MEMBER [SASystems]
GO
/****** Object:  Schema [Accounts]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
CREATE SCHEMA [Accounts]
GO
/****** Object:  Table [dbo].[Accounts]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Accounts](
	[ID] [bigint] NOT NULL,
	[CompanyID] [varchar](20) NULL,
	[AccountName] [varchar](100) NULL,
	[AccountType] [varchar](50) NULL,
	[AccountCode] [varchar](20) NULL,
	[AccountHead] [varchar](50) NULL,
	[CoaType] [varchar](50) NULL,
	[IsArchived] [varchar](50) NULL,
	[InsertedAt] [datetime] NULL,
	[InsertedBy] [varchar](50) NULL,
	[UpdatedAt] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
 CONSTRAINT [PK__Accounts__3214EC27986B6EB8] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[AccountsConfiguration]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AccountsConfiguration](
	[ConfigurationID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[CustomerInvoice] [varchar](5) NULL,
	[CreditNote] [varchar](5) NULL,
	[ReceivedVoucher] [varchar](5) NULL,
	[Customer] [varchar](5) NULL,
	[Quotation] [varchar](5) NULL,
	[PurchaseOrder] [varchar](5) NULL,
	[DebitNote] [varchar](5) NULL,
	[PaymentVoucher] [varchar](5) NULL,
	[Vendor] [varchar](5) NULL,
	[Requisition] [varchar](5) NULL,
	[JournalVocvher] [varchar](5) NULL,
	[Currency] [varchar](10) NULL,
	[GoodReceivedNote] [varchar](10) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[AccountsHead]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AccountsHead](
	[HeadID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[HeadName] [varchar](20) NULL,
	[HeadCode] [varchar](20) NULL,
	[Description] [varchar](100) NULL,
	[status] [bit] NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
 CONSTRAINT [PK_AccountsHead] PRIMARY KEY CLUSTERED 
(
	[HeadID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[AssetAssignment]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AssetAssignment](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Location] [varchar](50) NULL,
	[EmployeeID] [int] NULL,
	[Department] [varchar](150) NULL,
	[ProjectId] [int] NULL,
	[AssetID] [int] NULL,
 CONSTRAINT [PK_AssetAssignment] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[AssetBook]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AssetBook](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[AssetsName] [varchar](max) NULL,
	[Age] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[AssetID] [varchar](150) NULL,
	[StartingDate] [varchar](50) NULL,
	[PurchaseDate] [varchar](50) NULL,
	[ClosingDate] [varchar](50) NULL,
	[AssetDepreciationID] [int] NULL,
	[OpeningValue] [varchar](250) NULL,
	[ClosingValue] [varchar](250) NULL,
	[AssetCategoryID] [int] NULL,
	[ChangeType] [varchar](50) NULL,
	[DepreciationDate] [varchar](50) NULL,
 CONSTRAINT [PK_AssetBook] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[AssetDisposals]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AssetDisposals](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Type] [varchar](50) NULL,
	[SalvageValue] [varchar](50) NULL,
	[OpeningDate] [varchar](50) NULL,
	[ClosingDate] [varchar](50) NULL,
	[ApprovedBy] [varchar](50) NULL,
	[SupervisedBy] [varchar](50) NULL,
 CONSTRAINT [PK_AssetDisposals] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[AssetMondR]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AssetMondR](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Type] [varchar](50) NULL,
	[AssetID] [int] NULL,
	[ServiceInvoiceID] [int] NULL,
	[ApprovedBy] [varchar](50) NULL,
	[SupervisedBy] [varchar](50) NULL,
 CONSTRAINT [PK_AssetMondR] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Assets]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Assets](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[AssetID] [int] NOT NULL,
	[AssetsUniqueID] [varchar](50) NULL,
	[Quantity] [int] NOT NULL,
	[Unit] [varchar](250) NULL,
	[AssetType] [int] NOT NULL,
	[Remarks] [varchar](100) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Reference] [varchar](200) NULL,
	[ItemExpiry] [varchar](50) NULL,
	[CostUnit] [money] NULL,
	[Dated] [varchar](50) NULL,
	[SrNumber] [varchar](50) NULL,
	[AssignedTo] [int] NULL,
	[SalvageValue] [varchar](50) NULL,
	[EstLife] [varchar](50) NULL,
 CONSTRAINT [PK_Assets] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[AssetsLinkCoa]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[AssetsLinkCoa](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[AssetId] [int] NULL,
	[Name] [varchar](250) NULL,
	[CoaID] [bigint] NULL,
	[CoaName] [varchar](150) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
 CONSTRAINT [PK_AssetsLinkCoa] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Banks]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Banks](
	[BankID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[BankName] [varchar](255) NULL,
	[BankBranch] [varchar](100) NULL,
	[AccountNumber] [varchar](255) NULL,
	[AccountTitle] [varchar](255) NULL,
	[AccountType] [varchar](50) NULL,
	[Status] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[AccountID] [bigint] NULL,
	[AccountName] [varchar](250) NULL,
 CONSTRAINT [PK_BankID] PRIMARY KEY CLUSTERED 
(
	[BankID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ChildCompany]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ChildCompany](
	[ChildID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](20) NULL,
	[Type] [varchar](50) NULL,
	[COmpanyName] [varchar](50) NULL,
	[CompanyAddress] [varchar](200) NULL,
	[CompanyEmail] [varchar](50) NULL,
	[CompanyPhone] [varchar](50) NULL,
	[Status] [varchar](20) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[CompanyLogo]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CompanyLogo](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[LeftLogo] [varchar](150) NULL,
	[RightLogo] [varchar](150) NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[CompanyProject]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CompanyProject](
	[ProjectID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[ChildID] [varchar](50) NULL,
	[ProjectName] [varchar](255) NULL,
	[scope] [varchar](100) NULL,
	[FoundingDate] [datetime] NULL,
	[CompletingDate] [datetime] NULL,
	[IsRegisterd] [bit] NULL,
	[Budget] [money] NULL,
	[Status] [varchar](20) NULL,
	[COAID] [bigint] NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[CompanyProjects]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CompanyProjects](
	[ProjectID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[ChildID] [varchar](50) NULL,
	[ProjectName] [varchar](255) NULL,
	[scope] [varchar](100) NULL,
	[FoundingDate] [datetime] NULL,
	[CompletingDate] [datetime] NULL,
	[IsRegisterd] [bit] NULL,
	[Budget] [money] NULL,
	[Status] [varchar](20) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[COAID] [bigint] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[CurrenciesTable]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[CurrenciesTable](
	[CurrencyID] [int] IDENTITY(1,1) NOT NULL,
	[Currency] [varchar](255) NULL,
	[Symbol] [varchar](10) NULL,
	[Name] [varchar](255) NULL,
	[Status] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[CurrencyID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Currency_Codes]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Currency_Codes](
	[ID] [varchar](3) NULL,
	[IsArchived] [int] NULL,
	[InsertedAt] [datetime] NOT NULL,
	[InsertedBy] [varchar](255) NULL,
	[UpdatedAt] [datetime] NULL,
	[UpdatedBy] [varchar](255) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Customer]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Customer](
	[CustomerID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[CustomerType] [varchar](10) NULL,
	[CustomerName] [varchar](30) NULL,
	[FatherHusband] [varchar](30) NULL,
	[Email] [varchar](30) NULL,
	[Mobile] [varchar](20) NULL,
	[Phone] [varchar](20) NULL,
	[CNIC] [varchar](20) NULL,
	[DOB] [varchar](20) NULL,
	[Status] [varchar](10) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[DealerCommision]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[DealerCommision](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[DealerName] [varchar](100) NULL,
	[FilePlotID] [bigint] NULL,
	[CommisionAmmount] [money] NULL,
	[Module] [varchar](50) NULL,
	[Block] [varchar](50) NULL,
	[Description] [varchar](255) NULL,
	[Date] [date] NULL,
	[Process] [int] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Delivery]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Delivery](
	[DID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[DeliveryName] [varchar](20) NULL,
	[DType] [varchar](20) NULL,
	[DAmount] [int] NULL,
	[DComputation] [varchar](50) NULL,
	[Status] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
 CONSTRAINT [PK_Delivery] PRIMARY KEY CLUSTERED 
(
	[DID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[DeliveryDetail]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[DeliveryDetail](
	[DID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[DeliveryName] [varchar](20) NULL,
	[DeliveryType] [varchar](20) NULL,
	[DeliveryAmount] [money] NULL,
	[ReferenceAccount] [varchar](150) NULL,
	[Remarks] [varchar](100) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
 CONSTRAINT [PK_DeliveryDetail] PRIMARY KEY CLUSTERED 
(
	[DID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[DemandRequisition]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[DemandRequisition](
	[RequisitionId] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[RId] [varchar](20) NULL,
	[Dated] [varchar](50) NULL,
	[DepartmentName] [varchar](200) NULL,
	[ProjectName] [varchar](200) NULL,
	[Status] [varchar](50) NULL,
	[Narration] [varchar](1000) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[state] [int] NULL,
	[RequisitionType] [varchar](50) NULL,
	[ApprovedBy] [varchar](100) NULL,
	[ApprovedOn] [varchar](50) NULL,
	[Status2] [varchar](50) NULL,
 CONSTRAINT [PK_DemandRequisition] PRIMARY KEY CLUSTERED 
(
	[RequisitionId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[DemandRequisitionItem]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[DemandRequisitionItem](
	[RequisitionItemId] [int] IDENTITY(1,1) NOT NULL,
	[ReqID] [int] NULL,
	[itemId] [bigint] NULL,
	[ItemName] [varchar](250) NULL,
	[Quantity] [decimal](19, 3) NULL,
	[unit] [varchar](50) NULL,
	[EstCost] [money] NULL,
	[Detail] [varchar](max) NULL,
	[PStatus] [bit] NULL,
 CONSTRAINT [PK_DemandRequisitionItem] PRIMARY KEY CLUSTERED 
(
	[RequisitionItemId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[DepartmentProject]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[DepartmentProject](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[DepartmentName] [varchar](50) NULL,
	[DepartmentID] [int] NULL,
	[ProjectID] [int] NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[DepreciationAssets]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[DepreciationAssets](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Methods] [varchar](50) NULL,
	[Percentage] [varchar](200) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Status] [varchar](100) NULL,
	[AssetId] [varchar](50) NULL,
	[StartingDate] [varchar](50) NULL,
	[ClosingDate] [varchar](50) NULL,
	[StartingValue] [money] NULL,
	[ClosingValue] [money] NULL,
	[DepreciatedValue] [money] NULL,
 CONSTRAINT [PK_DepreciationAssets] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[DepreciationCategory]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[DepreciationCategory](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[DeprName] [varchar](50) NOT NULL,
	[Methods] [varchar](50) NULL,
	[Percentage] [varchar](200) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Status] [varchar](100) NULL,
	[CategoryId] [varchar](50) NULL,
	[StartingDate] [varchar](50) NULL,
 CONSTRAINT [PK_DepreciationCategory] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[DeptAccess]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[DeptAccess](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[EmployeeCode] [varchar](50) NULL,
	[Email] [varchar](100) NULL,
	[Username] [varchar](100) NULL,
	[d1] [varchar](200) NULL,
	[d2] [varchar](200) NULL,
	[d3] [varchar](200) NULL,
	[d4] [varchar](200) NULL,
	[d5] [varchar](200) NULL,
	[d6] [varchar](200) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Documents]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Documents](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[DocumentDate] [date] NULL,
	[DocumentNo] [varchar](100) NULL,
	[Description] [varchar](500) NULL,
	[DocumentComments] [varchar](900) NULL,
	[InternalComment] [varchar](500) NULL,
	[DocumentType] [varchar](20) NULL,
	[InsertedAt] [datetime] NULL,
	[InsertedBy] [varchar](50) NULL,
	[UpdatedAt] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[CompanyID] [varchar](50) NULL,
 CONSTRAINT [PK__Document__3214EC2783C77B98] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[GrnOrder]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[GrnOrder](
	[GrnOrderID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[Dated] [varchar](50) NULL,
	[POID] [int] NULL,
	[ReqID] [int] NULL,
	[GrnID] [varchar](50) NULL,
	[InvoiceNo] [varchar](50) NULL,
	[Remarks] [varchar](500) NULL,
	[Status] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[Status2] [varchar](20) NULL,
	[SupervisedBy] [varchar](50) NULL,
	[SupervisedOn] [varchar](50) NULL,
	[Photo] [varchar](200) NULL,
 CONSTRAINT [PK_GrnOrderID] PRIMARY KEY CLUSTERED 
(
	[GrnOrderID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[GrnOrderItems]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[GrnOrderItems](
	[GrnOrderItemID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[GrnID] [int] NOT NULL,
	[ItemId] [int] NOT NULL,
	[ItemName] [varchar](250) NULL,
	[PoQuantity] [decimal](19, 3) NULL,
	[Unit] [varchar](20) NULL,
	[RecvdQuantity] [decimal](19, 3) NULL,
	[ItemExpiry] [varchar](50) NULL,
	[Price] [money] NULL,
	[Detail] [varchar](max) NULL,
	[poid] [int] NULL,
 CONSTRAINT [PK_GrnOrderItemID] PRIMARY KEY CLUSTERED 
(
	[GrnOrderItemID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[HeadJournal]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[HeadJournal](
	[JournalID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[HeadId] [varchar](50) NULL,
	[JournalName] [varchar](50) NULL,
	[journalCode] [varchar](20) NULL,
	[Description] [varchar](100) NULL,
	[Status] [bit] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Inventory]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Inventory](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[ItemID] [int] NOT NULL,
	[Quantity] [decimal](19, 3) NOT NULL,
	[Unit] [varchar](250) NULL,
	[Type] [int] NOT NULL,
	[Remarks] [varchar](100) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Reference] [varchar](200) NULL,
	[ItemExpiry] [varchar](50) NULL,
	[CostUnit] [money] NULL,
	[Dated] [varchar](50) NULL,
 CONSTRAINT [PK_Inventory] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[IssuanceItem]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[IssuanceItem](
	[IssuanceItemId] [int] IDENTITY(1,1) NOT NULL,
	[IssuanceId] [int] NULL,
	[itemId] [int] NULL,
	[ItemName] [varchar](250) NULL,
	[ReqQuantity] [decimal](19, 3) NULL,
	[unit] [varchar](10) NULL,
	[IssuanceQuantity] [decimal](19, 3) NULL,
	[RID] [int] NULL,
 CONSTRAINT [PK_IssuanceItem] PRIMARY KEY CLUSTERED 
(
	[IssuanceItemId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[IssuanceReturn]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[IssuanceReturn](
	[IssuenceReturnID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[Dated] [varchar](50) NULL,
	[IssID] [int] NULL,
	[IRtnID] [varchar](50) NULL,
	[Remarks] [varchar](500) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[Status2] [varchar](20) NULL,
	[SupervisedBy] [varchar](50) NULL,
	[SupervisedOn] [varchar](50) NULL,
 CONSTRAINT [PK_IssuenceReturnID] PRIMARY KEY CLUSTERED 
(
	[IssuenceReturnID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[IssuanceReturnItem]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[IssuanceReturnItem](
	[IssuanceReturnItemId] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[IssuanceReturnId] [int] NULL,
	[ItemId] [int] NULL,
	[ItemName] [varchar](250) NULL,
	[IssuanceQuantity] [decimal](19, 3) NULL,
	[unit] [varchar](10) NULL,
	[ReturnQuantity] [decimal](19, 3) NULL,
 CONSTRAINT [PK_IssuanceReturnItem] PRIMARY KEY CLUSTERED 
(
	[IssuanceReturnItemId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Issuances]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Issuances](
	[IssuanceId] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[IssuanceCode] [varchar](20) NULL,
	[IssuanceDate] [varchar](20) NULL,
	[RequisitionId] [int] NULL,
	[DepartmentName] [varchar](200) NULL,
	[ProjectName] [varchar](200) NULL,
	[Status] [varchar](50) NULL,
	[Narration] [varchar](200) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[FProjectName] [varchar](200) NULL,
	[FDepartmentName] [varchar](200) NULL,
 CONSTRAINT [PK_Issuances] PRIMARY KEY CLUSTERED 
(
	[IssuanceId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ItemCategory]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ItemCategory](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[CategoryName] [varchar](50) NULL,
	[Description] [varchar](200) NULL,
	[Status] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[CategoryType] [varchar](50) NULL,
	[ShortCode] [varchar](50) NULL,
	[OpeningDate] [varchar](100) NULL,
	[ClosingDate] [varchar](100) NULL,
 CONSTRAINT [PK_ItemCategory] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ItemLinkCoa]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ItemLinkCoa](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[ItemId] [int] NULL,
	[Name] [varchar](250) NULL,
	[CoaID] [bigint] NULL,
	[CoaName] [varchar](150) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
 CONSTRAINT [PK_ItemLinkCoa] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ItemList]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ItemList](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[PartNumber] [varchar](50) NULL,
	[Name] [varchar](250) NULL,
	[LinkedDept] [varchar](250) NULL,
	[ItemCategory] [varchar](50) NULL,
	[Sold] [varchar](5) NULL,
	[Purchase] [varchar](5) NULL,
	[Consumed] [varchar](5) NULL,
	[ItemType] [varchar](20) NULL,
	[SaleCost] [int] NULL,
	[PurchaseCost] [int] NULL,
	[Status] [varchar](10) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[unit] [varchar](50) NULL,
	[ItemCode] [varchar](50) NULL,
 CONSTRAINT [PK_ItemList] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[JournalVoucher]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[JournalVoucher](
	[JournalVoucherID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[JVID] [varchar](50) NULL,
	[JVDate] [varchar](20) NULL,
	[TransactionAmount] [money] NULL,
	[Narration] [varchar](500) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[Status] [varchar](50) NULL,
 CONSTRAINT [PK_JournalVoucher] PRIMARY KEY CLUSTERED 
(
	[JournalVoucherID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[JournalVoucherDetail]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[JournalVoucherDetail](
	[JvDetailID] [int] IDENTITY(1,1) NOT NULL,
	[JournalVoucherID] [varchar](50) NULL,
	[AccountID] [bigint] NULL,
	[AccountName] [varchar](100) NULL,
	[Narration] [varchar](500) NULL,
	[credit_amount] [money] NULL,
	[debit_amount] [money] NULL,
 CONSTRAINT [PK_JournalVoucherDetail] PRIMARY KEY CLUSTERED 
(
	[JvDetailID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Ledger_Entries]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Ledger_Entries](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[TransactionID] [int] NULL,
	[AccountID] [bigint] NULL,
	[EntryType] [varchar](1) NULL,
	[Amount] [decimal](20, 2) NULL,
	[VendorID] [bigint] NULL,
	[VendorID2] [bigint] NULL,
	[VendorID3] [bigint] NULL,
	[VendorID4] [bigint] NULL,
	[VendorID5] [bigint] NULL,
	[VendorID6] [bigint] NULL,
	[VendorID7] [bigint] NULL,
	[InvAfterVerify] [bigint] NULL,
	[CompanyID] [varchar](50) NULL,
	[VendorID8] [bigint] NULL,
	[PVAfterVerify] [bigint] NULL,
	[VendorID8b] [int] NULL,
 CONSTRAINT [PK__Ledger_E__3214EC276145C6E8] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PaymentTerm]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PaymentTerm](
	[PaymentTermId] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[PaymentTermName] [varchar](200) NULL,
	[NoOfDays] [int] NULL,
	[PaymentType] [varchar](20) NULL,
	[PaymentScope] [varchar](20) NULL,
	[ExtraPayment] [money] NULL,
	[Status] [bit] NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PaymentVoucher]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PaymentVoucher](
	[PaymentVoucherID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[PVID] [varchar](50) NULL,
	[VoucherDate] [varchar](50) NULL,
	[AccountID] [bigint] NULL,
	[PaymentAgainst] [varchar](255) NULL,
	[InvoiceNumber] [varchar](500) NULL,
	[Amount] [money] NULL,
	[MethodType] [varchar](150) NULL,
	[MethodAccountID] [bigint] NULL,
	[Naration] [varchar](500) NULL,
	[SalesPerson] [varchar](100) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[ChqDate] [varchar](50) NULL,
	[ChqNumber] [varchar](50) NULL,
	[Status] [varchar](50) NULL,
	[AgainstPO] [varchar](50) NULL,
	[AgainstINV] [varchar](50) NULL,
	[TotalValue] [money] NULL,
	[RemainingValue] [money] NULL,
	[TaxAmount] [money] NULL,
	[TaxID] [bigint] NULL,
 CONSTRAINT [PK_PaymentVoucher] PRIMARY KEY CLUSTERED 
(
	[PaymentVoucherID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PaymentVoucherDetail]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PaymentVoucherDetail](
	[DetailID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[PID] [int] NULL,
	[Date] [varchar](50) NULL,
	[AgainstPO] [varchar](255) NULL,
	[AgainstINV] [varchar](255) NULL,
	[Amount] [money] NULL,
	[PVNO] [varchar](50) NULL,
	[Remaining] [money] NULL,
	[AgainstJV] [varchar](255) NULL,
 CONSTRAINT [PK_PaymentVoucherDetail] PRIMARY KEY CLUSTERED 
(
	[DetailID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PettyCash]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PettyCash](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[PettyID] [varchar](50) NULL,
	[CompanyID] [varchar](50) NULL,
	[DeptName] [varchar](150) NULL,
	[TotalAmount] [money] NULL,
	[PettyDate] [varchar](50) NULL,
	[Status1] [varchar](50) NULL,
	[Status2] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[PaidAmount] [money] NULL,
	[PVID] [varchar](50) NULL,
	[TotalPaid] [money] NULL,
	[Remaining] [money] NULL,
 CONSTRAINT [PK_PettyCash] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PettyCashAccess]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PettyCashAccess](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[AccountID] [bigint] NULL,
	[CompanyID] [varchar](50) NULL,
	[Name] [varchar](50) NULL,
	[EmployeeCode] [varchar](10) NULL,
	[Limit] [money] NULL,
	[COAID] [bigint] NULL,
	[COAName] [varchar](150) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Department] [varchar](150) NULL,
	[Status] [varchar](50) NULL,
	[UpdatedAmount] [money] NULL,
 CONSTRAINT [PK_PettyCashAccess] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PettyCashDetail]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PettyCashDetail](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[PID] [int] NULL,
	[VendorName] [varchar](150) NULL,
	[BillNumber] [varchar](50) NULL,
	[ItemDetail] [varchar](500) NULL,
	[Amount] [money] NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
 CONSTRAINT [PK_PettyCashDetail] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PQuotation]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PQuotation](
	[QuotationID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[VendorName] [varchar](200) NOT NULL,
	[RequisitionID] [int] NULL,
	[QuotationNumber] [int] NULL,
	[QuotationDate] [varchar](50) NULL,
	[SubTotal] [money] NULL,
	[Discount] [int] NULL,
	[Tax] [money] NULL,
	[ShippingCharges] [money] NULL,
	[Total] [money] NULL,
	[Remarks] [varchar](500) NULL,
	[Status] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[state] [int] NULL,
	[PaymentTerm] [varchar](200) NULL,
	[Photo] [varchar](200) NULL,
 CONSTRAINT [PK_PQuotation] PRIMARY KEY CLUSTERED 
(
	[QuotationID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PQuotationItems]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PQuotationItems](
	[QuotationItemID] [int] IDENTITY(1,1) NOT NULL,
	[QuotationID] [int] NULL,
	[ItemId] [bigint] NULL,
	[ItemName] [varchar](250) NULL,
	[Quantity] [decimal](19, 3) NULL,
	[Price] [money] NULL,
	[Unit] [varchar](50) NULL,
	[Total] [money] NULL,
	[Detail] [varchar](max) NULL,
	[State] [varchar](50) NULL,
 CONSTRAINT [PK_PQuotationItems] PRIMARY KEY CLUSTERED 
(
	[QuotationItemID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ProjectLinkCoa]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ProjectLinkCoa](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[ProjectName] [varchar](200) NULL,
	[CoaID] [bigint] NULL,
	[CoaName] [varchar](200) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PurchaseOrder]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PurchaseOrder](
	[PurchaseOrderID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[AgainstReq] [int] NULL,
	[AgainstQuo] [int] NULL,
	[PoCode] [varchar](50) NULL,
	[PoDate] [varchar](50) NULL,
	[vendorName] [varchar](200) NULL,
	[SubTotal] [money] NULL,
	[Discount] [int] NULL,
	[Tax] [money] NULL,
	[ShippingCharges] [money] NULL,
	[TotalAmount] [money] NULL,
	[Remarks] [varchar](500) NULL,
	[Status] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[Status2] [varchar](50) NULL,
	[state] [int] NULL,
	[pinv_state] [int] NULL,
	[RequisitionType] [varchar](50) NULL,
	[PaymentTerm] [varchar](200) NULL,
 CONSTRAINT [PK_PurchaseOrder] PRIMARY KEY CLUSTERED 
(
	[PurchaseOrderID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[PurchaseOrderItems]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[PurchaseOrderItems](
	[POItemID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[POID] [int] NULL,
	[ItemId] [bigint] NULL,
	[ItemName] [varchar](250) NULL,
	[QuoteQuantity] [decimal](19, 3) NULL,
	[Quantity] [decimal](19, 3) NULL,
	[Price] [money] NULL,
	[Unit] [varchar](50) NULL,
	[SubTotal] [money] NULL,
	[Detail] [varchar](max) NULL,
 CONSTRAINT [PK_PurchaseOrderItems] PRIMARY KEY CLUSTERED 
(
	[POItemID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ReceivedVoucher]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ReceivedVoucher](
	[ReceivedVoucherID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[RVID] [varchar](10) NULL,
	[VoucherDate] [varchar](50) NULL,
	[AccountID] [bigint] NULL,
	[PaymentAgainst] [varchar](255) NULL,
	[InvoiceNumber] [varchar](255) NULL,
	[Amount] [money] NULL,
	[MethodType] [varchar](50) NULL,
	[MethodAccountID] [bigint] NULL,
	[Naration] [varchar](500) NULL,
	[SalesPerson] [varchar](100) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[ChqDate] [varchar](50) NULL,
	[ChqNumber] [varchar](50) NULL,
	[Status] [varchar](50) NULL,
	[AgainstPO] [varchar](50) NULL,
	[AgainstINV] [varchar](50) NULL,
	[TotalValue] [money] NULL,
	[RemainingValue] [money] NULL,
	[InstrumentBank] [varchar](225) NULL,
	[Photo] [varchar](255) NULL,
	[Method] [varchar](50) NULL,
 CONSTRAINT [PK_ReceivedVoucher] PRIMARY KEY CLUSTERED 
(
	[ReceivedVoucherID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ReceivedVoucherDetail]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ReceivedVoucherDetail](
	[DetailID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[RID] [int] NULL,
	[Date] [varchar](50) NULL,
	[AgainstPO] [varchar](255) NULL,
	[AgainstINV] [varchar](255) NULL,
	[Amount] [money] NULL,
	[RVNO] [varchar](50) NULL,
	[Remaining] [money] NULL,
 CONSTRAINT [PK_ReceivedVoucherDetail] PRIMARY KEY CLUSTERED 
(
	[DetailID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ReceivingOrder]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ReceivingOrder](
	[ReceavingOrderID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[Dated] [varchar](50) NULL,
	[POID] [int] NULL,
	[ReqID] [int] NULL,
	[FormID] [varchar](50) NULL,
	[InvoiceNo] [varchar](50) NULL,
	[SubTotal] [money] NULL,
	[Discount] [money] NULL,
	[Tax] [money] NULL,
	[ShippingCharges] [money] NULL,
	[TotalAmount] [money] NULL,
	[Remarks] [varchar](500) NULL,
	[Status] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[Status2] [varchar](20) NULL,
	[SupervisedBy] [varchar](50) NULL,
	[SupervisedOn] [varchar](50) NULL,
	[PaymentTerm] [varchar](200) NULL,
	[GRNID] [int] NULL,
 CONSTRAINT [PK_ReceivingOrder] PRIMARY KEY CLUSTERED 
(
	[ReceavingOrderID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ReceivingOrderItems]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ReceivingOrderItems](
	[ROItemID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[ROID] [int] NOT NULL,
	[ItemId] [bigint] NULL,
	[ItemName] [varchar](250) NULL,
	[PoQuantity] [decimal](19, 3) NULL,
	[Unit] [varchar](50) NULL,
	[RecvdQuantity] [decimal](19, 3) NULL,
	[Price] [money] NULL,
	[SubTotal] [money] NULL,
	[ItemExpiry] [varchar](50) NULL,
	[Detail] [varchar](max) NULL,
 CONSTRAINT [PK_ReceivingOrderItems] PRIMARY KEY CLUSTERED 
(
	[ROItemID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ReceivingOrderReturn]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ReceivingOrderReturn](
	[ReturnOrderID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[Dated] [varchar](50) NULL,
	[InvID] [int] NULL,
	[RtnID] [varchar](50) NULL,
	[vendorName] [varchar](200) NULL,
	[InvoiceNo] [varchar](50) NULL,
	[SubTotal] [money] NULL,
	[Discount] [money] NULL,
	[Tax] [money] NULL,
	[ShippingCharges] [money] NULL,
	[TotalAmount] [money] NULL,
	[Remarks] [varchar](500) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[Status2] [varchar](20) NULL,
	[SupervisedBy] [varchar](50) NULL,
	[SupervisedOn] [varchar](50) NULL,
	[Type] [varchar](50) NULL,
 CONSTRAINT [PK_ReceivingOrderReturn] PRIMARY KEY CLUSTERED 
(
	[ReturnOrderID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ReceivingReturnItems]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ReceivingReturnItems](
	[RRItemID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[RRID] [int] NOT NULL,
	[ItemId] [bigint] NOT NULL,
	[ItemName] [varchar](250) NULL,
	[PoQuantity] [decimal](19, 3) NULL,
	[Unit] [varchar](50) NULL,
	[ReturnQuantity] [decimal](19, 3) NULL,
	[Price] [money] NULL,
	[SubTotal] [money] NULL,
	[ItemExpiry] [varchar](50) NULL,
 CONSTRAINT [PK_ReceivingReturnItems] PRIMARY KEY CLUSTERED 
(
	[RRItemID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Requisition]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Requisition](
	[RequisitionId] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[RId] [varchar](20) NULL,
	[Dated] [varchar](50) NULL,
	[DepartmentName] [varchar](200) NULL,
	[ProjectName] [varchar](200) NULL,
	[Status] [varchar](50) NULL,
	[Narration] [varchar](1000) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[q1] [varchar](10) NULL,
	[q2] [varchar](10) NULL,
	[q3] [varchar](10) NULL,
	[q4] [varchar](10) NULL,
	[q5] [varchar](10) NULL,
	[q6] [varchar](10) NULL,
	[state] [int] NULL,
	[RequisitionType] [varchar](50) NULL,
	[ApprovedBy] [varchar](100) NULL,
	[ApprovedOn] [varchar](50) NULL,
	[DemandRID] [int] NULL,
	[Status2] [varchar](50) NULL,
 CONSTRAINT [PK_Requisition] PRIMARY KEY CLUSTERED 
(
	[RequisitionId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[RequisitionItem]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[RequisitionItem](
	[RequisitionItemId] [int] IDENTITY(1,1) NOT NULL,
	[ReqID] [int] NULL,
	[itemId] [bigint] NULL,
	[ItemName] [varchar](250) NULL,
	[Quantity] [decimal](19, 3) NULL,
	[unit] [varchar](50) NULL,
	[EstCost] [money] NULL,
	[Detail] [varchar](max) NULL,
 CONSTRAINT [PK_RequisitionItem] PRIMARY KEY CLUSTERED 
(
	[RequisitionItemId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[SalesInvoice]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[SalesInvoice](
	[SalesInvoiceID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[CustomerID] [int] NULL,
	[Dated] [varchar](50) NULL,
	[saleID] [varchar](50) NULL,
	[InvoiceNo] [varchar](50) NULL,
	[SubTotal] [money] NULL,
	[Discount] [money] NULL,
	[Tax] [money] NULL,
	[ShippingCharges] [money] NULL,
	[TotalAmount] [money] NULL,
	[Remarks] [varchar](500) NULL,
	[Status] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[Status2] [varchar](20) NULL,
 CONSTRAINT [PK_SalesInvoice] PRIMARY KEY CLUSTERED 
(
	[SalesInvoiceID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[SalesInvoiceItems]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[SalesInvoiceItems](
	[SIItemID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[SIID] [int] NOT NULL,
	[ItemId] [bigint] NOT NULL,
	[ItemName] [varchar](250) NULL,
	[SaleQuantity] [decimal](19, 3) NULL,
	[Unit] [varchar](20) NULL,
	[Price] [money] NULL,
	[SubTotal] [money] NULL,
	[ItemExpiry] [varchar](50) NULL,
 CONSTRAINT [PK_SalesInvoiceItems] PRIMARY KEY CLUSTERED 
(
	[SIItemID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[SalesReturn]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[SalesReturn](
	[SaleReturnID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[Dated] [varchar](50) NULL,
	[InvID] [int] NULL,
	[SRtnID] [varchar](50) NULL,
	[customerName] [varchar](200) NULL,
	[InvoiceNo] [varchar](50) NULL,
	[SubTotal] [money] NULL,
	[Discount] [money] NULL,
	[Tax] [money] NULL,
	[ShippingCharges] [money] NULL,
	[TotalAmount] [money] NULL,
	[Remarks] [varchar](100) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[Status2] [varchar](20) NULL,
	[SupervisedBy] [varchar](50) NULL,
	[SupervisedOn] [varchar](50) NULL,
 CONSTRAINT [PK_SaleReturnID] PRIMARY KEY CLUSTERED 
(
	[SaleReturnID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[SalesReturnItems]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[SalesReturnItems](
	[SRItemID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[SRID] [int] NULL,
	[ItemId] [bigint] NULL,
	[ItemName] [varchar](250) NULL,
	[PoQuantity] [decimal](19, 3) NULL,
	[Unit] [varchar](20) NULL,
	[ReturnQuantity] [decimal](19, 3) NULL,
	[Price] [money] NULL,
	[SubTotal] [money] NULL,
 CONSTRAINT [PK_SRItemID] PRIMARY KEY CLUSTERED 
(
	[SRItemID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[SequenceVoucher]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[SequenceVoucher](
	[SvID] [int] IDENTITY(1,1) NOT NULL,
	[PVID] [varchar](50) NULL,
	[RefID] [int] NULL,
	[RefType] [varchar](50) NULL,
	[CompanyID] [varchar](50) NULL,
	[MonthId] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[SvID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ServiceBill]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ServiceBill](
	[ServiceBillId] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[SBId] [varchar](10) NULL,
	[Dated] [varchar](50) NULL,
	[ProjectName] [varchar](max) NULL,
	[ContractorName] [varchar](200) NULL,
	[WorkdoneAmount] [money] NULL,
	[BillAmount] [money] NULL,
	[Status] [varchar](50) NULL,
	[Narration] [varchar](1000) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
 CONSTRAINT [PK_ServiceBill] PRIMARY KEY CLUSTERED 
(
	[ServiceBillId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ServiceBillItem]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ServiceBillItem](
	[ServiceBillItemId] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[SBID] [int] NULL,
	[ServiceName] [varchar](250) NULL,
	[unit] [varchar](50) NULL,
	[Quantity] [decimal](19, 3) NULL,
	[Rate] [money] NULL,
	[TotalAmount] [money] NULL,
	[Amount] [money] NULL,
	[Balance] [money] NULL,
	[Detail] [varchar](max) NULL,
 CONSTRAINT [PK_ServiceBillItem] PRIMARY KEY CLUSTERED 
(
	[ServiceBillItemId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Session]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Session](
	[SessionID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[SessionName] [varchar](30) NULL,
	[StartDate] [datetime] NULL,
	[EndDate] [datetime] NULL,
	[Status] [bit] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[SQuotation]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[SQuotation](
	[QuotationID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[CustomerName] [varchar](100) NOT NULL,
	[Dated] [varchar](50) NULL,
	[QuotationNumber] [varchar](50) NULL,
	[SubTotal] [money] NULL,
	[Discount] [int] NULL,
	[Tax] [money] NULL,
	[ShippingCharges] [money] NULL,
	[Total] [money] NULL,
	[Remarks] [varchar](50) NULL,
	[Status] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
	[Session] [varchar](50) NULL,
	[state] [int] NULL,
 CONSTRAINT [PK_SQuotation] PRIMARY KEY CLUSTERED 
(
	[QuotationID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[SQuotationItems]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[SQuotationItems](
	[QuotationItemID] [int] IDENTITY(1,1) NOT NULL,
	[QuotationID] [varchar](50) NULL,
	[ItemId] [bigint] NULL,
	[ItemName] [varchar](250) NULL,
	[Quantity] [decimal](19, 3) NULL,
	[Price] [money] NULL,
	[Unit] [varchar](50) NULL,
	[Total] [money] NULL,
	[Detail] [varchar](255) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TaxDetail]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TaxDetail](
	[TaxID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[TaxName] [varchar](20) NULL,
	[TaxType] [varchar](20) NULL,
	[TaxAmount] [money] NULL,
	[ReferenceAccount] [varchar](150) NULL,
	[Remarks] [varchar](100) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
 CONSTRAINT [PK_TaxesDetail] PRIMARY KEY CLUSTERED 
(
	[TaxID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Taxes]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Taxes](
	[TaxID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[TaxName] [varchar](20) NULL,
	[TaxType] [varchar](20) NULL,
	[TaxAmount] [int] NULL,
	[TaxComputation] [varchar](50) NULL,
	[Status] [varchar](50) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
 CONSTRAINT [PK_Taxes] PRIMARY KEY CLUSTERED 
(
	[TaxID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TempBank]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TempBank](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[PVID] [varchar](50) NULL,
	[VendorId] [varchar](50) NULL,
	[VendorName] [varchar](200) NULL,
	[ChqNo] [varchar](50) NULL,
	[ChqDate] [varchar](50) NULL,
	[ChqAmount] [varchar](20) NULL,
	[ClearanceDate] [varchar](50) NULL,
	[Clearanceby] [varchar](50) NULL,
	[ClearanceAccountID] [bigint] NULL,
	[ClearanceAccountName] [varchar](255) NULL,
	[Status] [varchar](100) NULL,
 CONSTRAINT [PK_TempBank] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TempBankSales]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TempBankSales](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[RVID] [varchar](50) NULL,
	[VendorId] [varchar](50) NULL,
	[VendorName] [varchar](200) NULL,
	[ChqNo] [varchar](50) NULL,
	[ChqDate] [varchar](50) NULL,
	[ChqAmount] [varchar](20) NULL,
	[ClearanceDate] [varchar](50) NULL,
	[Clearanceby] [varchar](50) NULL,
	[ClearanceAccountID] [bigint] NULL,
	[ClearanceAccountName] [varchar](255) NULL,
	[Status] [varchar](100) NULL,
	[InstrumentBank] [varchar](255) NULL,
	[Method] [varchar](50) NULL,
 CONSTRAINT [PK_TempBankSales] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TempBookingTable]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TempBookingTable](
	[BID] [int] IDENTITY(1,1) NOT NULL,
	[Id] [int] NULL,
	[File_Plot_Id] [varchar](100) NULL,
	[file_plot_number] [varchar](100) NULL,
	[Type] [varchar](255) NULL,
	[Block_Name] [varchar](255) NULL,
	[UnitModule] [varchar](255) NULL,
	[BookingAmount] [money] NULL,
	[OwnerName] [varchar](255) NULL,
	[Dated] [varchar](50) NULL,
	[Supervision] [varchar](50) NULL,
	[SupervisionBy] [varchar](50) NULL,
PRIMARY KEY CLUSTERED 
(
	[BID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TempCancellation_Receipts]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TempCancellation_Receipts](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[Rid] [int] NULL,
	[ReceiptNo] [nvarchar](500) NULL,
	[File_Plot_No] [bigint] NULL,
	[File_Plot_Number] [nvarchar](150) NULL,
	[Block] [nvarchar](150) NULL,
	[Name] [nvarchar](max) NULL,
	[Father_Name] [nvarchar](max) NULL,
	[Contact] [nvarchar](50) NULL,
	[Project] [nvarchar](max) NULL,
	[Size] [nvarchar](50) NULL,
	[Plot_Total_Amount] [numeric](15, 2) NULL,
	[Amount] [numeric](15, 2) NULL,
	[Type] [nvarchar](150) NULL,
	[TokenParameter] [bigint] NULL,
	[DateTime] [varchar](50) NULL,
	[Module] [nvarchar](250) NULL,
	[Description] [nvarchar](max) NULL,
	[Userid] [bigint] NULL,
	[Cancel] [bit] NULL,
	[Text] [nvarchar](max) NULL,
	[Phase] [nvarchar](50) NULL,
	[Receipt_Type] [nvarchar](50) NULL,
	[Deduction] [decimal](5, 2) NULL,
	[Repurchased_Amt] [decimal](15, 2) NULL,
	[Deduction_Amt] [decimal](15, 2) NULL,
	[Plot_Type] [varchar](50) NULL,
	[Status] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[PaidAmount] [money] NULL,
	[RemainingAmount] [money] NULL,
	[AccountID] [bigint] NULL,
	[PVID] [varchar](50) NULL,
 CONSTRAINT [PK_TempCancellation_Receipts] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TempElectricityBooking]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TempElectricityBooking](
	[EID] [int] IDENTITY(1,1) NOT NULL,
	[Block] [varchar](200) NULL,
	[Plot_Type] [varchar](200) NULL,
	[Total] [money] NULL,
	[Dated] [varchar](50) NULL,
	[username] [varchar](50) NULL,
	[Status] [varchar](50) NULL,
 CONSTRAINT [PK_TempElectricityBooking] PRIMARY KEY CLUSTERED 
(
	[EID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TempPaymentTable]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TempPaymentTable](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[PId] [varchar](50) NULL,
	[ReceiptNo] [nvarchar](500) NULL,
	[Name] [nvarchar](max) NULL,
	[Father_Name] [nvarchar](max) NULL,
	[Amount] [money] NULL,
	[PaymentType] [nvarchar](50) NULL,
	[Transaction_Id] [nvarchar](500) NULL,
	[Bank] [nvarchar](250) NULL,
	[Ch_Pay_Draft_No] [nvarchar](200) NULL,
	[Ch_Pay_Draft_Date] [datetime] NULL,
	[Branch_Name] [nvarchar](max) NULL,
	[File_Plot_No] [bigint] NULL,
	[Type] [nvarchar](150) NULL,
	[DateTime] [varchar](50) NULL,
	[Text] [nvarchar](max) NULL,
	[Module] [nvarchar](150) NULL,
	[Plot_Type] [nvarchar](500) NULL,
	[Userid] [int] NULL,
	[Block] [nvarchar](350) NULL,
	[Phase] [nvarchar](50) NULL,
	[File_Plot_Number] [nvarchar](150) NULL,
	[status] [varchar](50) NULL,
 CONSTRAINT [PK__TempPaymentTable] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TempProjects]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TempProjects](
	[ProjectID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[ChildID] [varchar](50) NULL,
	[ProjectName] [varchar](255) NULL,
	[scope] [varchar](100) NULL,
	[FoundingDate] [datetime] NULL,
	[CompletingDate] [datetime] NULL,
	[IsRegisterd] [bit] NULL,
	[Budget] [money] NULL,
	[Status] [varchar](20) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TempReceiptTable]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TempReceiptTable](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[RId] [varchar](50) NULL,
	[ReceiptNo] [nvarchar](500) NULL,
	[Name] [nvarchar](max) NULL,
	[Father_Name] [nvarchar](max) NULL,
	[Amount] [money] NULL,
	[PaymentType] [nvarchar](50) NULL,
	[Transaction_Id] [nvarchar](500) NULL,
	[Bank] [nvarchar](250) NULL,
	[Ch_Pay_Draft_No] [nvarchar](200) NULL,
	[Ch_Pay_Draft_Date] [datetime] NULL,
	[Branch_Name] [nvarchar](max) NULL,
	[File_Plot_No] [bigint] NULL,
	[Type] [nvarchar](150) NULL,
	[DateTime] [varchar](50) NULL,
	[Text] [nvarchar](max) NULL,
	[Module] [nvarchar](150) NULL,
	[Plot_Type] [nvarchar](500) NULL,
	[Userid] [int] NULL,
	[Block] [nvarchar](350) NULL,
	[Phase] [nvarchar](50) NULL,
	[File_Plot_Number] [nvarchar](150) NULL,
	[status] [varchar](50) NULL,
	[Project] [varchar](150) NULL,
 CONSTRAINT [PK__TempRece__3214EC279F062242] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TempServicesBooking]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TempServicesBooking](
	[SRID] [int] IDENTITY(1,1) NOT NULL,
	[Block] [varchar](200) NULL,
	[Plot_Type] [varchar](200) NULL,
	[Total] [money] NULL,
	[Dated] [varchar](50) NULL,
	[username] [varchar](50) NULL,
	[Status] [varchar](50) NULL,
 CONSTRAINT [PK__TempServ__A09710AAA28FAF54] PRIMARY KEY CLUSTERED 
(
	[SRID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Transactions]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Transactions](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[DocumentID] [int] NULL,
	[TransactionDate] [date] NULL,
	[Description] [varchar](500) NULL,
	[CompanyID] [varchar](50) NULL,
 CONSTRAINT [PK__Transact__3214EC27D8E27AC5] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[TypesLinkCoa]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[TypesLinkCoa](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[TypeName] [varchar](50) NULL,
	[CoaID] [bigint] NULL,
	[CoaName] [varchar](150) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [datetime] NULL,
	[UpdatedBy] [varchar](50) NULL,
	[UpdatedOn] [varchar](50) NULL,
 CONSTRAINT [PK_TypesLinkCoa] PRIMARY KEY CLUSTERED 
(
	[ID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Unit]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Unit](
	[UnitID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyID] [varchar](50) NULL,
	[UnitName] [varchar](20) NULL,
	[UnitType] [varchar](20) NULL,
	[Status] [varchar](10) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[UnitCashCounter]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[UnitCashCounter](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[UserID] [int] NULL,
	[Name] [varchar](50) NULL,
	[Group] [varchar](50) NULL,
	[Roles] [varchar](100) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[UnitsAdjustOnlineCash]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[UnitsAdjustOnlineCash](
	[AdjustID] [int] IDENTITY(1,1) NOT NULL,
	[ID] [int] NULL,
	[RId] [nvarchar](50) NULL,
	[ReceiptNo] [nvarchar](500) NULL,
	[Name] [nvarchar](max) NULL,
	[Father_Name] [nvarchar](max) NULL,
	[Amount] [money] NULL,
	[PaymentType] [nvarchar](50) NULL,
	[Transaction_Id] [nvarchar](500) NULL,
	[Bank] [nvarchar](250) NULL,
	[Ch_Pay_Draft_No] [nvarchar](200) NULL,
	[Ch_Pay_Draft_Date] [datetime] NULL,
	[Branch_Name] [nvarchar](max) NULL,
	[File_Plot_No] [bigint] NULL,
	[Type] [nvarchar](150) NULL,
	[DateTime] [varchar](50) NULL,
	[Text] [nvarchar](max) NULL,
	[Module] [nvarchar](150) NULL,
	[Plot_Type] [nvarchar](500) NULL,
	[Userid] [int] NULL,
	[Block] [nvarchar](350) NULL,
	[Phase] [nvarchar](50) NULL,
	[File_Plot_Number] [nvarchar](150) NULL,
	[Status] [varchar](50) NULL,
	[DepositedID] [bigint] NULL,
	[Project] [varchar](150) NULL,
 CONSTRAINT [PK__UnitsAdjustOnlineCash] PRIMARY KEY CLUSTERED 
(
	[AdjustID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[UnitsCashDetail]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[UnitsCashDetail](
	[CashID] [int] IDENTITY(1,1) NOT NULL,
	[ID] [int] NULL,
	[RId] [nvarchar](50) NULL,
	[ReceiptNo] [nvarchar](500) NULL,
	[Name] [nvarchar](max) NULL,
	[Father_Name] [nvarchar](max) NULL,
	[Amount] [money] NULL,
	[PaymentType] [nvarchar](50) NULL,
	[Transaction_Id] [nvarchar](500) NULL,
	[Bank] [nvarchar](250) NULL,
	[Ch_Pay_Draft_No] [nvarchar](200) NULL,
	[Ch_Pay_Draft_Date] [datetime] NULL,
	[Branch_Name] [nvarchar](max) NULL,
	[File_Plot_No] [bigint] NULL,
	[Type] [nvarchar](150) NULL,
	[DateTime] [varchar](50) NULL,
	[Text] [nvarchar](max) NULL,
	[Module] [nvarchar](150) NULL,
	[Plot_Type] [nvarchar](500) NULL,
	[Userid] [int] NULL,
	[Block] [nvarchar](350) NULL,
	[Phase] [nvarchar](50) NULL,
	[File_Plot_Number] [nvarchar](150) NULL,
	[Status] [varchar](50) NULL,
	[Project] [varchar](150) NULL,
 CONSTRAINT [PK__UnitsCashDetail] PRIMARY KEY CLUSTERED 
(
	[CashID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[UnitsChqDetail]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[UnitsChqDetail](
	[ChqID] [int] IDENTITY(1,1) NOT NULL,
	[ID] [int] NOT NULL,
	[RId] [nvarchar](50) NULL,
	[ReceiptNo] [nvarchar](500) NULL,
	[Name] [nvarchar](max) NULL,
	[Father_Name] [nvarchar](max) NULL,
	[Amount] [money] NULL,
	[PaymentType] [nvarchar](50) NULL,
	[Transaction_Id] [nvarchar](500) NULL,
	[Bank] [nvarchar](250) NULL,
	[Ch_Pay_Draft_No] [nvarchar](200) NULL,
	[Ch_Pay_Draft_Date] [datetime] NULL,
	[Branch_Name] [nvarchar](max) NULL,
	[File_Plot_No] [bigint] NULL,
	[Type] [nvarchar](150) NULL,
	[DateTime] [varchar](50) NULL,
	[Text] [nvarchar](max) NULL,
	[Module] [nvarchar](150) NULL,
	[Plot_Type] [nvarchar](500) NULL,
	[Userid] [int] NULL,
	[Block] [nvarchar](350) NULL,
	[Phase] [nvarchar](50) NULL,
	[File_Plot_Number] [nvarchar](150) NULL,
	[DepositedAccount] [varchar](255) NULL,
	[DepositedID] [bigint] NULL,
	[DepositDate] [varchar](50) NULL,
	[ClearanceDateTime] [varchar](50) NULL,
	[Status] [varchar](50) NULL,
	[DiscartReason] [varchar](max) NULL,
	[Project] [varchar](150) NULL,
 CONSTRAINT [PK__UnitsChqDetail] PRIMARY KEY CLUSTERED 
(
	[ChqID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[UnitsDebitCreditDetail]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[UnitsDebitCreditDetail](
	[DbtID] [int] IDENTITY(1,1) NOT NULL,
	[ID] [int] NULL,
	[RId] [nvarchar](50) NULL,
	[ReceiptNo] [nvarchar](500) NULL,
	[Name] [nvarchar](max) NULL,
	[Father_Name] [nvarchar](max) NULL,
	[Amount] [money] NULL,
	[PaymentType] [nvarchar](50) NULL,
	[Transaction_Id] [nvarchar](500) NULL,
	[Bank] [nvarchar](250) NULL,
	[Ch_Pay_Draft_No] [nvarchar](200) NULL,
	[Ch_Pay_Draft_Date] [datetime] NULL,
	[Branch_Name] [nvarchar](max) NULL,
	[File_Plot_No] [bigint] NULL,
	[Type] [nvarchar](150) NULL,
	[DateTime] [varchar](50) NULL,
	[Text] [nvarchar](max) NULL,
	[Module] [nvarchar](150) NULL,
	[Plot_Type] [nvarchar](500) NULL,
	[Userid] [int] NULL,
	[Block] [nvarchar](350) NULL,
	[Phase] [nvarchar](50) NULL,
	[File_Plot_Number] [nvarchar](150) NULL,
	[Status] [varchar](50) NULL,
	[Project] [varchar](150) NULL,
 CONSTRAINT [PK__UnitsDebitCreditDetail] PRIMARY KEY CLUSTERED 
(
	[DbtID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[UnitsOnlineCash]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[UnitsOnlineCash](
	[OnlineID] [int] IDENTITY(1,1) NOT NULL,
	[ID] [int] NULL,
	[RId] [nvarchar](50) NULL,
	[ReceiptNo] [nvarchar](500) NULL,
	[Name] [nvarchar](max) NULL,
	[Father_Name] [nvarchar](max) NULL,
	[Amount] [money] NULL,
	[PaymentType] [nvarchar](50) NULL,
	[Transaction_Id] [nvarchar](500) NULL,
	[Bank] [nvarchar](250) NULL,
	[Ch_Pay_Draft_No] [nvarchar](200) NULL,
	[Ch_Pay_Draft_Date] [datetime] NULL,
	[Branch_Name] [nvarchar](max) NULL,
	[File_Plot_No] [bigint] NULL,
	[Type] [nvarchar](150) NULL,
	[DateTime] [varchar](50) NULL,
	[Text] [nvarchar](max) NULL,
	[Module] [nvarchar](150) NULL,
	[Plot_Type] [nvarchar](500) NULL,
	[Userid] [int] NULL,
	[Block] [nvarchar](350) NULL,
	[Phase] [nvarchar](50) NULL,
	[File_Plot_Number] [nvarchar](150) NULL,
	[Status] [varchar](50) NULL,
	[DepositedID] [bigint] NULL,
	[Project] [varchar](150) NULL,
 CONSTRAINT [PK__UnitsOnlineCash] PRIMARY KEY CLUSTERED 
(
	[OnlineID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[Vendor]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Vendor](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[CompanyName] [varchar](100) NOT NULL,
	[Email] [varchar](50) NULL,
	[Address] [varchar](100) NULL,
	[Mobile] [varchar](20) NULL,
	[Phone] [varchar](20) NULL,
	[Status] [varchar](10) NULL,
	[CreatedBy] [varchar](50) NULL,
	[CreatedOn] [varchar](50) NULL,
	[UpdatedBy] [varchar](50) NULL,
	[CompanyID] [varchar](50) NULL,
	[type] [varchar](30) NULL,
	[weblink] [varchar](250) NULL,
	[UpdatedOn] [varchar](50) NULL
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[CompanyProjects] ADD  DEFAULT ((1)) FOR [IsRegisterd]
GO
ALTER TABLE [dbo].[DemandRequisition] ADD  DEFAULT ((0)) FOR [state]
GO
ALTER TABLE [dbo].[DemandRequisitionItem] ADD  DEFAULT ((0)) FOR [PStatus]
GO
ALTER TABLE [dbo].[PaymentTerm] ADD  DEFAULT ((1)) FOR [Status]
GO
ALTER TABLE [dbo].[PaymentVoucher] ADD  CONSTRAINT [DF_PaymentVoucher_TaxAmount]  DEFAULT ((0)) FOR [TaxAmount]
GO
ALTER TABLE [dbo].[PettyCash] ADD  CONSTRAINT [DF_PettyCash_TotalPaid]  DEFAULT ((0)) FOR [TotalPaid]
GO
ALTER TABLE [dbo].[PettyCash] ADD  CONSTRAINT [DF_PettyCash_Remaining]  DEFAULT ((0)) FOR [Remaining]
GO
ALTER TABLE [dbo].[PQuotation] ADD  CONSTRAINT [DF_PQuotation_Tax]  DEFAULT ((0)) FOR [Tax]
GO
ALTER TABLE [dbo].[PQuotation] ADD  CONSTRAINT [DF_PQuotation_ShippingCharges]  DEFAULT ((0)) FOR [ShippingCharges]
GO
ALTER TABLE [dbo].[PQuotation] ADD  CONSTRAINT [DF_PQuotation_Total]  DEFAULT ((0)) FOR [Total]
GO
ALTER TABLE [dbo].[PQuotation] ADD  CONSTRAINT [DF_PQuotation_state]  DEFAULT ((0)) FOR [state]
GO
ALTER TABLE [dbo].[PurchaseOrder] ADD  CONSTRAINT [DF_PurchaseOrder_state]  DEFAULT ((0)) FOR [state]
GO
ALTER TABLE [dbo].[PurchaseOrder] ADD  CONSTRAINT [DF_PurchaseOrder_pinv_state]  DEFAULT ((0)) FOR [pinv_state]
GO
ALTER TABLE [dbo].[Requisition] ADD  CONSTRAINT [DF__Requisiti__Statu__17F790F9]  DEFAULT ((1)) FOR [Status]
GO
ALTER TABLE [dbo].[Requisition] ADD  CONSTRAINT [DF_Requisition_state]  DEFAULT ((0)) FOR [state]
GO
ALTER TABLE [dbo].[Session] ADD  DEFAULT ((0)) FOR [Status]
GO
ALTER TABLE [dbo].[Taxes] ADD  CONSTRAINT [DF__Taxes__Status__4CA06362]  DEFAULT ((0)) FOR [Status]
GO
ALTER TABLE [dbo].[TempCancellation_Receipts] ADD  CONSTRAINT [DF_TempCancellation_Receipts_PaidAmount]  DEFAULT ((0)) FOR [PaidAmount]
GO
ALTER TABLE [dbo].[TempCancellation_Receipts] ADD  CONSTRAINT [DF_TempCancellation_Receipts_RemainingAmount]  DEFAULT ((0)) FOR [RemainingAmount]
GO
ALTER TABLE [dbo].[Ledger_Entries]  WITH CHECK ADD  CONSTRAINT [FK__Ledger_En__Trans__3F466844] FOREIGN KEY([TransactionID])
REFERENCES [dbo].[Transactions] ([ID])
GO
ALTER TABLE [dbo].[Ledger_Entries] CHECK CONSTRAINT [FK__Ledger_En__Trans__3F466844]
GO
ALTER TABLE [dbo].[Transactions]  WITH CHECK ADD  CONSTRAINT [FK__Transacti__Docum__403A8C7D] FOREIGN KEY([DocumentID])
REFERENCES [dbo].[Documents] ([ID])
GO
ALTER TABLE [dbo].[Transactions] CHECK CONSTRAINT [FK__Transacti__Docum__403A8C7D]
GO
/****** Object:  StoredProcedure [dbo].[Account_Balance]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
Create Procedure [dbo].[Account_Balance]
@Datefrom datetime
as begin
SELECT  e.AccountID, a.AccountName,
SUM(CASE WHEN e.EntryType='D' THEN e.amount ELSE -e.amount END) AS Balance
FROM Transactions t
LEFT JOIN ledger_entries e ON e.TransactionID = t.id
LEFT JOIN Accounts a ON a.id = e.AccountID
WHERE t.TransactionDate <=@Datefrom  GROUP BY e.AccountID
, a.AccountName
ORDER BY CAST(e.AccountID AS CHAR);
end
GO
/****** Object:  StoredProcedure [dbo].[Account_turnover]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
Create Procedure [dbo].[Account_turnover]
@ID bigint,
@Datefrom datetime,
@DateTo datetime
as begin
SELECT  t.TransactionDate, t.Description, 
(CASE WHEN e.EntryType='D' THEN e.Amount ELSE 0 END) AS DebitAmount,
(CASE WHEN e.EntryType='C' THEN e.Amount ELSE 0 END) AS CreditAmount
FROM Transactions t
LEFT JOIN ledger_entries e ON e.TransactionID = t.id
WHERE t.TransactionDate >= @Datefrom AND t.TransactionDate <=@DateTo
AND e.AccountID = @ID
ORDER BY t.TransactionDate
end
GO
/****** Object:  StoredProcedure [dbo].[Accounts_Check]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Accounts_Check]
as begin 

SELECT VendorID2, COUNT(VendorID2)
FROM [dbo].[Ledger_Entries]
GROUP BY VendorID2
HAVING COUNT(VendorID2) > 2




SELECT ID, COUNT(ID)
FROM UnitsOnlineCash
GROUP BY ID
HAVING COUNT(ID) > 1

SELECT ID, COUNT(ID)
FROM [dbo].[UnitsAdjustOnlineCash]
GROUP BY ID
HAVING COUNT(ID) > 1

SELECT ID, COUNT(ID)
FROM [dbo].[UnitsChqDetail]
GROUP BY ID
HAVING COUNT(ID) > 1

SELECT ID, COUNT(ID)
FROM [dbo].[UnitsDebitCreditDetail]
GROUP BY ID
HAVING COUNT(ID) > 1

SELECT ID, COUNT(ID)
FROM [dbo].[UnitsCashDetail]
GROUP BY ID
HAVING COUNT(ID) > 1

SELECT TransactionID, COUNT(TransactionID)
FROM [dbo].[Ledger_Entries]
GROUP BY TransactionID
HAVING COUNT(TransactionID) = 1

;with temp as (
SELECT c.TransactionID, sum(c.amount) as 'C-sum', d.[D-sum]
  FROM [Account_Finance].[dbo].[Ledger_Entries] as c
  inner join (SELECT TransactionID, sum(amount) as 'D-sum'
  FROM [Account_Finance].[dbo].[Ledger_Entries]
  where EntryType = 'D'
  group by TransactionID) as d
  on d.TransactionID = c.TransactionID
  where c.EntryType = 'C'
  group by c.TransactionID, d.[D-sum]
  )
  select * from temp
  where [C-sum]-[D-sum] > 1.00 or [D-sum]-[C-sum] > 1.00
  select * from Ledger_Entries where AccountID is null
   select * from Ledger_Entries where AccountID = 0
   select sum(Amount) from Ledger_Entries where EntryType='C'
  select sum(Amount) from Ledger_Entries where EntryType='D'

  end 
GO
/****** Object:  StoredProcedure [dbo].[AdvanceAgainst_PendingPO]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE Procedure [dbo].[AdvanceAgainst_PendingPO]
@PoCode varchar (100)

as begin 
select [PVID], [VoucherDate], [AccountID], [PaymentAgainst], [InvoiceNumber], [Amount], [MethodType]
     , [Naration], [Session] , [Status]
from PaymentVoucher
where InvoiceNumber in 
(
SELECT PoCode
  FROM [PurchaseOrder]
  where
 [state] = 0
  and 
  [Status2]= 'Not Delivered'
  and PoCode = @PoCode
  )
  and [Status] = 'Approved'
  
  end 
GO
/****** Object:  StoredProcedure [dbo].[AgingReport]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
Create Procedure [dbo].[AgingReport]

@Datefrom datetime,
@DateTo datetime,
@DateAfter datetime

as begin

SELECT  e.AccountID, a.AccountName,
SUM(CASE WHEN t.TransactionDate < @Datefrom AND e.EntryType='D' 
         THEN e.amount ELSE 0.0 END) AS TotalDebitBefore,
SUM(CASE WHEN t.TransactionDate < @Datefrom AND e.EntryType='C' 
         THEN e.amount ELSE 0.0 END) AS TotalCreditBefore,
SUM(CASE WHEN t.TransactionDate >= @Datefrom AND 
    t.TransactionDate < @DateTo  AND e.EntryType='D' 
    THEN e.amount ELSE 0.0 END) AS DebitFirstPeriod,
SUM(CASE WHEN t.TransactionDate >= @Datefrom AND t.TransactionDate < @DateTo 
         AND e.EntryType='C' THEN e.amount ELSE 0.0 END) AS CreditFirstPeriod,
SUM(CASE WHEN t.TransactionDate >= @DateTo AND e.EntryType='D' 
         THEN e.amount ELSE 0.0 END) AS DebitSecondPeriod,
SUM(CASE WHEN t.TransactionDate >= @DateTo AND e.EntryType='C' 
         THEN e.amount ELSE 0.0 END) AS CreditSecondPeriod
FROM Transactions t
LEFT JOIN ledger_entries e ON e.TransactionID = t.id
LEFT JOIN Accounts a ON a.id = e.AccountID
WHERE t.TransactionDate <=@DateAfter GROUP BY e.AccountID ,a.AccountName
       ORDER BY CAST(e.AccountID AS CHAR);
end
GO
/****** Object:  StoredProcedure [dbo].[Asset_Count]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create procedure [dbo].[Asset_Count]
as begin 

create table #temp (TotalAssets int , AvailablelProdect int ,stockQuantity int , lowStockProduct int  )


;with cte as (

SELECT COUNT (ID) as TotalAssets
  FROM [Account_Finance].[dbo].[ItemList]
  where ItemType = 'Assets' 
  )
  select * into Temp from cte 
 

  insert into #temp (AvailablelProdect ,stockQuantity )
   exec  [dbo].[RemainingAssets]


 
   select ( Select TotalAssets from Temp ) as TotalAssets ,AvailablelProdect as AvailablelAssets  ,stockQuantity,(( Select TotalAssets from Temp ) -AvailablelProdect) as lowStockAssets  
   from #temp t 



   drop table #temp
   drop table temp
   end 
GO
/****** Object:  StoredProcedure [dbo].[Assets_Details]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Assets_Details]
as begin
;with cte as (
select (select SUM (Quantity) TotalAssets from Assets
where AssetType = 1 )TotalAssets ,
(select SUM (Quantity) AssignedAssets from Assets
where AssetType = 2)AssignedAssets
)
select TotalAssets , (TotalAssets - AssignedAssets) AvailableAsset , AssignedAssets
from cte
end
GO
/****** Object:  StoredProcedure [dbo].[BalanceSheet]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE Procedure [dbo].[BalanceSheet]

@DateFrom date , 
@DateTo date 
as begin 

	
	create table #temp (AccountID bigint	,AccountName varchar (100),AccountType varchar (100),Debit varchar (100),Credit varchar (100))
	;WITH cte
	AS (
		SELECT e.AccountID
			,a.AccountName , a.AccountType
			,SUM(CASE
					WHEN e.EntryType = 'D'
						THEN e.amount
					ELSE 0.0
					END) AS TotalDebit
			,SUM(CASE
					WHEN e.EntryType = 'C'
						THEN e.amount
					ELSE 0.0
					END) AS TotalCredit
		FROM Transactions t
		LEFT JOIN ledger_entries e ON e.TransactionID = t.id
		LEFT JOIN Accounts a ON a.id = e.AccountID
	--WHERE
	--	t.TransactionDate BETWEEN @Datefrom
	--		AND @DateTo
	--	AND a.CompanyID = @compid
		GROUP BY e.AccountID
			,a.AccountName , a.AccountType
		)  
		--,ctee as (
		insert into #temp (AccountID	,AccountName,AccountType,Debit,Credit)
		select AccountID	,AccountName,AccountType,
	case when 	AccountType  in ('Assets' , 'Equity' )  then (TotalDebit  - TotalCredit) else 0.0 end as Debit,
    case when 	AccountType  = 'Liabilities'        then (TotalCredit - TotalDebit)  else 0.0 end as Credit
	 from cte


	begin 
		 update #temp 
		 set Credit = Debit  , debit = Credit
		 where AccountType  in ('Assets' , 'Equity' )  and sign (Debit)= -1  

		  update #temp 
		 set Debit  = Credit  , Credit = Debit
		 where AccountType = 'Liabilities'   and sign (Credit)= -1  
	 end 


	 ;with balancesheet
as (		 select AccountID	,AccountName,AccountType,  
		 --(Debit)Debit , (Credit)Credit 
		 case when  sign (Debit)= -1   then abs( Debit ) else  Debit end as Debit , 		 case when  sign (Credit)= -1   then abs( Credit ) else  Credit end as Credit 

		 from  #temp)
		 select  AccountName , case when Debit = 0 then Credit when credit = 0 then Debit when Debit = 0 and credit = 0 then '-' else 0 end as Amount , AccountType
		 from balancesheet

		 drop table #temp
	
end 
GO
/****** Object:  StoredProcedure [dbo].[BalanceSheet_CurrentAssets]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE Procedure [dbo].[BalanceSheet_CurrentAssets]

@DateFrom date , 
@DateTo date 
as begin 

	

CREATE TABLE #Accounts(
	[ID] [bigint] NOT NULL,
	[CompanyID] [varchar](20) NULL,
	[AccountName] [varchar](100) NULL,
	[AccountType] [varchar](50) NULL,
	[AccountCode] [varchar](20) NULL,
	[AccountHead] [varchar](50) NULL,
	[CoaType] [varchar](50) NULL,

)
insert into #Accounts ([ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType])
select                 [ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType]  
from Accounts
WHERE AccountCode = '101'





;WITH cte
AS (
  SELECT e.AccountID, a.AccountName, a.AccountType,
         SUM(CASE WHEN e.EntryType = 'D' THEN e.amount ELSE 0.0 END) AS TotalDebit,
         SUM(CASE WHEN e.EntryType = 'C' THEN e.amount ELSE 0.0 END) AS TotalCredit
  FROM Transactions t
  LEFT JOIN ledger_entries e ON e.TransactionID = t.id
  LEFT JOIN Accounts a ON a.id = e.AccountID
  WHERE 
  t.TransactionDate BETWEEN @Datefrom AND @DateTo
    and e.AccountID LIKE '101%'
  GROUP BY e.AccountID, a.AccountName, a.AccountType
)  
, ctee as (
SELECT AccountID,(AccountName)  , SUM(TotalDebit - TotalCredit) AS TotalAmount
FROM cte
GROUP BY AccountID, AccountName
--order by AccountID
)
select left (AccountID,6) as AccountID ,pp.AccountName , SUM (TotalAmount) as Amount
from  ctee ee
join #Accounts pp on left (AccountID,6) = pp.ID
group by left (AccountID,6),pp.AccountName

drop table #Accounts

	
end 
GO
/****** Object:  StoredProcedure [dbo].[BalanceSheet_CurrentLiabiities]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE Procedure [dbo].[BalanceSheet_CurrentLiabiities]

@DateFrom date , 
@DateTo date 
as begin 



CREATE TABLE #Accounts(
	[ID] [bigint] NOT NULL,
	[CompanyID] [varchar](20) NULL,
	[AccountName] [varchar](100) NULL,
	[AccountType] [varchar](50) NULL,
	[AccountCode] [varchar](20) NULL,
	[AccountHead] [varchar](50) NULL,
	[CoaType] [varchar](50) NULL,

)
insert into #Accounts ([ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType])
select                 [ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType]  
from Accounts
WHERE AccountCode = '201'





;WITH cte
AS (
  SELECT e.AccountID, a.AccountName, a.AccountType,
         SUM(CASE WHEN e.EntryType = 'D' THEN e.amount ELSE 0.0 END) AS TotalDebit,
         SUM(CASE WHEN e.EntryType = 'C' THEN e.amount ELSE 0.0 END) AS TotalCredit
  FROM Transactions t
  LEFT JOIN ledger_entries e ON e.TransactionID = t.id
  LEFT JOIN Accounts a ON a.id = e.AccountID
  WHERE 
  t.TransactionDate BETWEEN @Datefrom AND @DateTo
    and e.AccountID LIKE '201%'
  GROUP BY e.AccountID, a.AccountName, a.AccountType
)  
, ctee as (
SELECT AccountID,(AccountName)  , SUM(TotalCredit -TotalDebit) AS TotalAmount
FROM cte
GROUP BY AccountID, AccountName
--order by AccountID
)
select left (AccountID,6) as AccountID ,pp.AccountName , SUM (TotalAmount) as Amount
from  ctee ee
join #Accounts pp on left (AccountID,6) = pp.ID
group by left (AccountID,6),pp.AccountName

drop table #Accounts


	
end 
GO
/****** Object:  StoredProcedure [dbo].[BalanceSheet_Dashboard]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create Procedure[dbo].[BalanceSheet_Dashboard]


 
  
@Date1 date ,
@Date2   date 
as begin 
declare 
  @columns NVARCHAR(MAX) = '', 
  @sql     NVARCHAR(MAX) = ''
create table #tempMain (CA money , NCA money  , CL money, NCL money, SCR money )

-------------- Executing Balance SPs
create table #Ctemp(AccountID bigint , AccountName varchar (200) , AccountType varchar (100) , Amount money)
insert into #Ctemp(AccountID,AccountName,AccountType,Amount)
EXEC	 [dbo].[BalanceSheet_CurrentAssets]
		@DateFrom = @Date1,
		@DateTo   = @Date2 

		insert into #tempMain (CA)
		select SUM (Amount) as CurrentAssets from #Ctemp
		drop table #Ctemp


create table #Btemp(AccountID bigint , AccountName varchar (200) , AccountType varchar (100) , Amount money)
insert into #Btemp(AccountID,AccountName,AccountType,Amount)
EXEC	 [dbo].[BalanceSheet_NonCurrentAssets]
		@DateFrom = @Date1,
		@DateTo   = @Date2 


	insert into #tempMain (NCA)
    select SUM (Amount) as NonCurrentAssets from #Btemp
		drop table #Btemp

create table #Ltemp(AccountID bigint , AccountName varchar (200) , AccountType varchar (100) , Amount money)
insert into #Ltemp(AccountID,AccountName,AccountType,Amount)
EXEC	 [dbo].[BalanceSheet_CurrentLiabiities]
		@DateFrom = @Date1,
		@DateTo   = @Date2 


	insert into #tempMain (CL)
		select SUM (Amount) as CurrentLiabiities from #Ltemp
		drop table #Ltemp


create table #Ntemp(AccountID bigint , AccountName varchar (200) , AccountType varchar (100) , Amount money)
insert into #Ntemp(AccountID,AccountName,AccountType,Amount)
EXEC	[dbo].[BalanceSheet_NonCurrentLiabiities]
		@DateFrom = @Date1,
		@DateTo   = @Date2 


			insert into #tempMain (NCL)
		select SUM (Amount) as NonCurrentLiabiities from #Ntemp
		drop table #Ntemp
	

	create table #Stemp(AccountID bigint , AccountName varchar (200) , AccountType varchar (100) , Amount money)
insert into #Stemp(AccountID,AccountName,AccountType,Amount)
EXEC	[dbo].[BalanceSheet_ShareCapitalandReserves]
		@DateFrom = @Date1,
		@DateTo   = @Date2 


	insert into #tempMain (SCR)
		select SUM (Amount) as ShareCapitalandReserves from #Stemp
		drop table #Stemp
-------------------- Insert Income Statment Result in one Table  
	

------------------using CTE to Pivot the Income Statment Heads
		;with cte as (
		SELECT CA ,'CurrentAssets' as Head
FROM #tempMain
WHERE CA IS NOT NULL

UNION

SELECT  NCA , 'NOnCurrentAssets' as Head
FROM #tempMain
WHERE NCA IS NOT NULL

UNION

SELECT  CL , 'CurrentLiabilities' as Head
FROM #tempMain
WHERE CL IS NOT NULL

UNION

SELECT  NCL , 'NOnCurrentLiabilities' as Head
FROM #tempMain
WHERE CL IS NOT NULL

UNION

SELECT  SCR , 'ShareCapitalReserve' as Head
FROM #tempMain
WHERE SCR IS NOT NULL
)



-- select the Head names
SELECT 
    @columns+=QUOTENAME(Head) + ','
FROM 
    cte;

-- remove the last comma
SET @columns = LEFT(@columns, LEN(@columns) - 1);


-- construct dynamic SQL
SET @sql ='
SELECT * FROM   
(
   		SELECT CA ,''CurrentAssets'' as Head
FROM #tempMain
WHERE CA IS NOT NULL

UNION

SELECT  NCA , ''NOnCurrentAssets'' as Head
FROM #tempMain
WHERE NCA IS NOT NULL

UNION

SELECT  CL , ''CurrentLiabilities'' as Head
FROM #tempMain
WHERE CL IS NOT NULL

UNION

SELECT  NCL , ''NOnCurrentLiabilities'' as Head
FROM #tempMain
WHERE CL IS NOT NULL

UNION

SELECT  SCR , ''ShareCapitalReserve'' as Head
FROM #tempMain
WHERE SCR IS NOT NULL
) t 
PIVOT(
    max(CA) 
    FOR Head IN ('+ @columns +')
) AS pivot_table;';

-- execute the dynamic SQL
EXECUTE sp_executesql @sql;
drop table #tempMain
end
GO
/****** Object:  StoredProcedure [dbo].[BalanceSheet_NonCurrentAssets]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE Procedure [dbo].[BalanceSheet_NonCurrentAssets]

@DateFrom date , 
@DateTo date 
as begin 


CREATE TABLE #Accounts(
	[ID] [bigint] NOT NULL,
	[CompanyID] [varchar](20) NULL,
	[AccountName] [varchar](100) NULL,
	[AccountType] [varchar](50) NULL,
	[AccountCode] [varchar](20) NULL,
	[AccountHead] [varchar](50) NULL,
	[CoaType] [varchar](50) NULL,

)
insert into #Accounts ([ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType])
select                 [ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType]  
from Accounts
WHERE AccountCode = '102'





;WITH cte
AS (
  SELECT e.AccountID, a.AccountName, a.AccountType,
         SUM(CASE WHEN e.EntryType = 'D' THEN e.amount ELSE 0.0 END) AS TotalDebit,
         SUM(CASE WHEN e.EntryType = 'C' THEN e.amount ELSE 0.0 END) AS TotalCredit
  FROM Transactions t
  LEFT JOIN ledger_entries e ON e.TransactionID = t.id
  LEFT JOIN Accounts a ON a.id = e.AccountID
  WHERE 
  t.TransactionDate BETWEEN @Datefrom AND @DateTo
   and  e.AccountID LIKE '102%'
  GROUP BY e.AccountID, a.AccountName, a.AccountType
)  
, ctee as (
SELECT AccountID,(AccountName)  , SUM(TotalDebit - TotalCredit) AS TotalAmount
FROM cte
GROUP BY AccountID, AccountName
--order by AccountID
)
select left (AccountID,6) as AccountID ,pp.AccountName , SUM (TotalAmount) as Amount
from  ctee ee
join #Accounts pp on left (AccountID,6) = pp.ID
group by left (AccountID,6),pp.AccountName

drop table #Accounts
	
end 
GO
/****** Object:  StoredProcedure [dbo].[BalanceSheet_NonCurrentLiabiities]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE Procedure [dbo].[BalanceSheet_NonCurrentLiabiities]

@DateFrom date , 
@DateTo date 
as begin 

	
CREATE TABLE #Accounts(
	[ID] [bigint] NOT NULL,
	[CompanyID] [varchar](20) NULL,
	[AccountName] [varchar](100) NULL,
	[AccountType] [varchar](50) NULL,
	[AccountCode] [varchar](20) NULL,
	[AccountHead] [varchar](50) NULL,
	[CoaType] [varchar](50) NULL,

)
insert into #Accounts ([ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType])
select                 [ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType]  
from Accounts
WHERE AccountCode = '202'





;WITH cte
AS (
  SELECT e.AccountID, a.AccountName, a.AccountType,
         SUM(CASE WHEN e.EntryType = 'D' THEN e.amount ELSE 0.0 END) AS TotalDebit,
         SUM(CASE WHEN e.EntryType = 'C' THEN e.amount ELSE 0.0 END) AS TotalCredit
  FROM Transactions t
  LEFT JOIN ledger_entries e ON e.TransactionID = t.id
  LEFT JOIN Accounts a ON a.id = e.AccountID
  WHERE 
  t.TransactionDate BETWEEN @Datefrom AND @DateTo
   and  e.AccountID LIKE '202%'
  GROUP BY e.AccountID, a.AccountName, a.AccountType
)  
, ctee as (
SELECT AccountID,(AccountName)  , SUM(TotalCredit -TotalDebit) AS TotalAmount
FROM cte
GROUP BY AccountID, AccountName
--order by AccountID
)
select left (AccountID,6) as AccountID ,pp.AccountName , SUM (TotalAmount) as Amount
from  ctee ee
join #Accounts pp on left (AccountID,6) = pp.ID
group by left (AccountID,6),pp.AccountName

drop table #Accounts


	


	
end 
GO
/****** Object:  StoredProcedure [dbo].[BalanceSheet_ShareCapitalandReserves]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE Procedure [dbo].[BalanceSheet_ShareCapitalandReserves]

@DateFrom date , 
@DateTo date 
as begin 

	

	
CREATE TABLE #Accounts(
	[ID] [bigint] NOT NULL,
	[CompanyID] [varchar](20) NULL,
	[AccountName] [varchar](100) NULL,
	[AccountType] [varchar](50) NULL,
	[AccountCode] [varchar](20) NULL,
	[AccountHead] [varchar](50) NULL,
	[CoaType] [varchar](50) NULL,

)
insert into #Accounts ([ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType])
select                 [ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType]  
from Accounts
WHERE AccountCode in ( '301' , '302')





;WITH cte
AS (
  SELECT e.AccountID, a.AccountName, a.AccountType,
         SUM(CASE WHEN e.EntryType = 'D' THEN e.amount ELSE 0.0 END) AS TotalDebit,
         SUM(CASE WHEN e.EntryType = 'C' THEN e.amount ELSE 0.0 END) AS TotalCredit
  FROM Transactions t
  LEFT JOIN ledger_entries e ON e.TransactionID = t.id
  LEFT JOIN Accounts a ON a.id = e.AccountID
  WHERE 
  t.TransactionDate BETWEEN @Datefrom AND @DateTo
   and  e.AccountID LIKE '3%'
  GROUP BY e.AccountID, a.AccountName, a.AccountType
)  
, ctee as (
SELECT AccountID,(AccountName)  , SUM(TotalCredit -TotalDebit) AS TotalAmount
FROM cte
GROUP BY AccountID, AccountName
--order by AccountID
)
select left (AccountID,6) as AccountID ,pp.AccountName , SUM (TotalAmount) as Amount
from  ctee ee
join #Accounts pp on left (AccountID,6) = pp.ID
group by left (AccountID,6),pp.AccountName

drop table #Accounts


	

	
end 
GO
/****** Object:  StoredProcedure [dbo].[Balancesheet_TotalProfit]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE  Procedure [dbo].[Balancesheet_TotalProfit]

@DateFrom date , 
@DateTo date 
--@AccountType varchar (20)
as begin 


with cte as (

 SELECT e.AccountID, a.AccountName, a.AccountType,
         SUM(CASE WHEN e.EntryType = 'D' THEN e.amount ELSE 0.0 END) AS TotalDebit,
         SUM(CASE WHEN e.EntryType = 'C' THEN e.amount ELSE 0.0 END) AS TotalCredit
  FROM Transactions t
  LEFT JOIN ledger_entries e ON e.TransactionID = t.id
  LEFT JOIN Accounts a ON a.id = e.AccountID
  WHERE 
 -- t.TransactionDate BETWEEN @DateFrom AND @DateTo
   --and  
   e.AccountID LIKE '4%' or  e.AccountID LIKE '5%'
  GROUP BY e.AccountID, a.AccountName, a.AccountType
	),
	
	

	 CTEE  as(
	select AccountID , AccountName, AccountType ,case when AccountType = 'Expenses' then  (TotalDebit  - TotalCredit)   else 0 end as Expenses,
	                                      case when AccountType = 'Income'   then  (TotalCredit - TotalDebit)    else 0 end as Income
	from cte
	

	)


	select   'AcumullatedProfit' as AccountName  , sum (Income - Expenses)as Amount 
	from CTEE
	--group  by AccountHead , AccountType
	
	
end 
GO
/****** Object:  StoredProcedure [dbo].[CFS_FinancingActivities]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create procedure [dbo].[CFS_FinancingActivities]
@DateFRom date ,
@DateTo date 
as begin 





with cte as (


select a.ID , a.AccountType , AccountName , CoaType , AccountHead
	,SUM(CASE 
				
				WHEN t.TransactionDate between  @DateFrom and @DateTo
					AND e.EntryType = 'D'
					THEN e.amount
				ELSE 0.0
				END) AS TotalDebitBefore
		,SUM(CASE 
				WHEN t.TransactionDate   between  @DateFrom and @DateTo
					AND e.EntryType = 'C'
					THEN e.amount
				ELSE 0.0
				END) AS TotalCreditBefore
	
	
		FROM Documents d
	LEFT JOIN Transactions t ON t.DocumentID = d.ID
	LEFT JOIN Ledger_Entries e ON e.TransactionID = t.ID
	LEFT JOIN Accounts a ON a.id = e.AccountID
	where  
	AccountType  in ('Income','Expenses')
	and
	CoaType = 'Transaction'
	group  by    AccountName , AccountType , CoaType ,a.ID , AccountHead
	),
	
	

	 CTEE  as(
	select ID , AccountHead, AccountType ,case when AccountType =  'Income'    then    ABS(TotalDebitBefore  - TotalCreditBefore) 
	                                           when AccountType  =  'Expenses'  then    ABS(TotalCreditBefore - TotalDebitBefore)    else 0 end as Amount
	from cte
	

	)


	select  AccountHead  ,  Sum (Amount) as Amount  , AccountType
	from CTEE
	group  by AccountHead , AccountType



end 
GO
/****** Object:  StoredProcedure [dbo].[CFS_InvestingActivities]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create procedure [dbo].[CFS_InvestingActivities]
@DateFRom date ,
@DateTo date 
as begin 





with cte as (


select a.ID , a.AccountType , AccountName , CoaType , AccountHead
	,SUM(CASE 
				
				WHEN t.TransactionDate between  @DateFrom and @DateTo
					AND e.EntryType = 'D'
					THEN e.amount
				ELSE 0.0
				END) AS TotalDebitBefore
		,SUM(CASE 
				WHEN t.TransactionDate   between  @DateFrom and @DateTo
					AND e.EntryType = 'C'
					THEN e.amount
				ELSE 0.0
				END) AS TotalCreditBefore
	
	
		FROM Documents d
	LEFT JOIN Transactions t ON t.DocumentID = d.ID
	LEFT JOIN Ledger_Entries e ON e.TransactionID = t.ID
	LEFT JOIN Accounts a ON a.id = e.AccountID
	where  
	AccountType  in ('Income','Expenses')
	and
	CoaType = 'Transaction'
	group  by    AccountName , AccountType , CoaType ,a.ID , AccountHead
	),
	
	

	 CTEE  as(
	select ID , AccountHead, AccountType ,case when AccountType =  'Income'    then    ABS(TotalDebitBefore  - TotalCreditBefore) 
	                                           when AccountType  =  'Expenses'  then    ABS(TotalCreditBefore - TotalDebitBefore)    else 0 end as Amount
	from cte
	

	)


	select  AccountHead  ,  Sum (Amount) as Amount  , AccountType
	from CTEE
	group  by AccountHead , AccountType



end 
GO
/****** Object:  StoredProcedure [dbo].[CFS_OPeratingActivities]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create procedure [dbo].[CFS_OPeratingActivities]
@DateFRom date ,
@DateTo date 
as begin 





with cte as (


select a.ID , a.AccountType , AccountName , CoaType , AccountHead
	,SUM(CASE 
				
				WHEN t.TransactionDate between  @DateFrom and @DateTo
					AND e.EntryType = 'D'
					THEN e.amount
				ELSE 0.0
				END) AS TotalDebitBefore
		,SUM(CASE 
				WHEN t.TransactionDate   between  @DateFrom and @DateTo
					AND e.EntryType = 'C'
					THEN e.amount
				ELSE 0.0
				END) AS TotalCreditBefore
	
	
		FROM Documents d
	LEFT JOIN Transactions t ON t.DocumentID = d.ID
	LEFT JOIN Ledger_Entries e ON e.TransactionID = t.ID
	LEFT JOIN Accounts a ON a.id = e.AccountID
	where  
	AccountType  in ('Income','Expenses')
	and
	CoaType = 'Transaction'
	group  by    AccountName , AccountType , CoaType ,a.ID , AccountHead
	),
	
	

	 CTEE  as(
	select ID , AccountHead, AccountType ,case when AccountType =  'Income'    then    ABS(TotalDebitBefore  - TotalCreditBefore) 
	                                           when AccountType  =  'Expenses'  then    ABS(TotalCreditBefore - TotalDebitBefore)    else 0 end as Amount
	from cte
	

	)


	select  AccountHead  ,  Sum (Amount) as Amount  , AccountType
	from CTEE
	group  by AccountHead , AccountType



end 
GO
/****** Object:  StoredProcedure [dbo].[Consumption_Report]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create Procedure [dbo].[Consumption_Report]
@datefrom date ,
@dateto date , 
@itemID varchar (100) 
as begin 

	;with cte as (
	SELECT DISTINCT il.Name,il.PurchaseCost,il.ItemCategory , ic.CategoryName 
		,i.ItemID , il.ItemCode
		, (i.[Quantity])*(i.CostUnit) as cost, i.Quantity , it.IssuanceQuantity , [IssuanceDate]
	FROM  Inventory i
	INNER JOIN ItemList il
		ON i.ItemID = il.ID
	INNER JOIN ItemCategory ic
	    ON IC.ID = il.ItemCategory
    INNER JOIN IssuanceItem it
	    ON i.ItemID = it.itemId
	INNER JOIN Issuances s
	    ON it.IssuanceId = s.IssuanceId
		--where i.CompanyID = @CompID 
		)

		select    ItemCategory , CategoryName , Name,ItemCode,PurchaseCost,
		ItemID,sum (cost)/sum ([Quantity]) [AVG] , sum (IssuanceQuantity)
		from cte
		where Name = @itemID
		and [IssuanceDate] = @datefrom
	group by [ItemID] ,  Name,PurchaseCost, ItemCategory , CategoryName   ,ItemCode
		end




GO
/****** Object:  StoredProcedure [dbo].[dashboard]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[dashboard] @Datefrom DATETIME
	,@DateTo DATETIME
	,@id BIGINT
	,@compid VARCHAR(50)
AS
BEGIN
	CREATE TABLE #temp (
		code BIGINT
		,name VARCHAR(30)
		,amount DECIMAL(20, 2)
		);
	WITH cte
	AS (
		SELECT e.AccountID
			,a.AccountName,a.AccountType 
			,SUM(CASE
					WHEN e.EntryType = 'D'
						THEN e.amount
					ELSE 0.0
					END) AS TotalDebit
			,SUM(CASE
					WHEN e.EntryType = 'C'
						THEN e.amount
					ELSE 0.0
					END) AS TotalCredit
		FROM Transactions t
		LEFT JOIN ledger_entries e ON e.TransactionID = t.id
		LEFT JOIN Accounts a ON a.id = e.AccountID
		WHERE t.TransactionDate BETWEEN @Datefrom
				AND @DateTo
			AND e.AccountID LIKE CONCAT (
				@id
				,'%'
				)
			AND a.CompanyID = @Compid
		GROUP BY e.AccountID
			,a.AccountName,a.AccountType 
		)
	SELECT AccountID
		,AccountName
		,case when AccountType in ('Liabilities' ,'Expense' ) then (TotalCredit - TotalDebit) else (TotalDebit - TotalCredit) end  AS am
	FROM cte
	DROP TABLE #temp
END
GO
/****** Object:  StoredProcedure [dbo].[dashboard_TotalCredit]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
Create PROCEDURE [dbo].[dashboard_TotalCredit] @Datefrom DATETIME
	,@DateTo DATETIME
	,@id BIGINT
	,@compid VARCHAR(50)
AS
BEGIN
	
	WITH cte
	AS (
		SELECT e.AccountID
			,a.AccountName
			,SUM(CASE WHEN e.EntryType = 'D' THEN e.amount	ELSE 0.0 END) AS TotalDebit
			
			,SUM(CASE
					WHEN e.EntryType = 'C'
						THEN e.amount
					ELSE 0.0
					END) AS TotalCredit
		FROM Transactions t
		LEFT JOIN ledger_entries e ON e.TransactionID = t.id
		LEFT JOIN Accounts a ON a.id = e.AccountID
		WHERE t.TransactionDate BETWEEN  @Datefrom
				AND  @DateTo
			AND e.AccountID LIKE CONCAT (
				@id
				,'%'
				)
			AND a.CompanyID = @compid
		GROUP BY e.AccountID
			,a.AccountName
		)
	
	SELECT
		sum ( TotalDebit) AS Totaldebit,sum ( TotalCredit) AS TotalCredit
	FROM cte
	
	
END
GO
/****** Object:  StoredProcedure [dbo].[General_Journal]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE Procedure   [dbo].[General_Journal]
as begin 
set nocount on 
SELECT  t.TransactionDate AS Date, t.description AS DescriptionOrAccountTitle, 
null as AmountDebit, null AS AmountCredit, t.id AS Reference, null AS IsLine , d.DocumentType
FROM Transactions t
LEFT JOIN ledger_entries e ON e.TransactionID = t.id
LEFT JOIN Accounts a ON a.id = e.AccountID
LEFT JOIN Documents d ON d.id = t.DocumentID
WHERE t.TransactionDate BETWEEN '2023-01-01' AND '2023-12-30'
UNION
SELECT null AS Date, (CASE WHEN e.EntryType = 'D' THEN
a.AccountName ELSE CONCAT('-  ', a.AccountName) END) AS DescriptionOrAccountTitle,
(CASE WHEN e.EntryType = 'D' THEN e.amount ELSE null END) AS AmountDebit,
(CASE WHEN e.EntryType = 'C' THEN e.amount ELSE null END) AS AmountDebit,
t.id AS Reference, (CASE WHEN e.EntryType = 'D' THEN 1 ELSE 2 END) AS IsLine , d.DocumentType
FROM transactions t
LEFT JOIN ledger_entries e ON e.TransactionID = t.id
LEFT JOIN accounts a ON a.id = e.AccountID
LEFT JOIN Documents d ON d.id = t.DocumentID
WHERE t.transactiondate BETWEEN '2023-01-01' AND '2023-12-30'
ORDER BY TransactionDate;
end
GO
/****** Object:  StoredProcedure [dbo].[GET_DealerCommission]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE Procedure  [dbo].[GET_DealerCommission]
as begin 


insert into DealerCommision
       ([DealerName], [FilePlotID], [CommisionAmmount], [Module], [Block], [Description], [Date], [Process])




(SELECT [Dealer_Name],[File_Plot_Id],[Com_Amount],[Module]
	   ,f.[Block] as block--,substring ([Text] , charindex( ':' , [Text])+1 ,  10 ) as block
       ,[Text] ,d.[Datetime]  ,[Process]
  FROM 
        [192.168.11.161].[SA_MIS].[dbo].[Dealer_Commession] d
  join  [192.168.11.161].[SA_MIS].[dbo].[File_Form] f         on d.[File_Plot_Id] = f. [Id]
  where Process = 1
  and cast ( d.[Datetime] as date ) > (select max([Date]) from DealerCommision )
  )

	union all


  (SELECT [Dealer_Name],[File_Plot_Id],[Com_Amount],[Module]
	    --,substring ([Text] , charindex( ':' , [Text])+1 ,  10 ) as block
          ,p.Block_Name as block,[Text],d.[Datetime] ,[Process]
   FROM 
         [192.168.11.161].[SA_MIS].[dbo].[Dealer_Commession] d
   join  [192.168.11.161].[SA_MIS].[dbo].[Plots] p              on d.[File_Plot_Id] = p. [Id]
   where Process = 1
     and cast ( d.[Datetime] as date )  > (select max([Date]) from DealerCommision )
)

  end 
GO
/****** Object:  StoredProcedure [dbo].[Get_Item_AverageCostValue]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Get_Item_AverageCostValue]


@CompanyID varchar(50),
@itemname varchar(100) 
as begin 

;with cte as (
  select [ItemCode],il.Name ,([Quantity])*(CostUnit) as cost, Quantity
    FROM [Account_Finance].[dbo].[Inventory] i 
	join  [Account_Finance].[dbo].[ItemList]il on i.ItemID = il.ID
	where Type = 1
	and i.CompanyID = @CompanyID
	
	)
	select [ItemCode],[Name], (CASE
				WHEN sum([Quantity]) > 0   and sum(cost) > 0
				THEN  (convert(DECIMAL(10, 2), sum(cost) / sum([Quantity])))
				ELSE 0.00
				END) as [AVG] from cte
	where [Name] = case when @itemname ='' then [Name] else @itemname end 
	group by [ItemCode] ,[Name] 


	end 
GO
/****** Object:  StoredProcedure [dbo].[Get_Item_AverageCostValue_ItemWise]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE procedure [dbo].[Get_Item_AverageCostValue_ItemWise]


@CompanyID varchar(50),
@itemid int 
as begin 

;with cte as (
  select [ItemID], ([Quantity])*(CostUnit) as cost, Quantity, CompanyID
    FROM [dbo].[Inventory]
	where Type = 1
	--and CompanyID = @CompanyID
	--group by [ItemID]
	)
	select [ItemID],sum (cost)/sum ([Quantity]) [AVG] from cte
	
	WHERE  CompanyID = @CompanyID
	    AND ItemID = @itemid
	group by [ItemID]


	end 
GO
/****** Object:  StoredProcedure [dbo].[IncomeStatment]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE Procedure [dbo].[IncomeStatment]

@DateFrom date , 
@DateTo date 
--@AccountType varchar (20)
as begin 


with cte as (


select a.ID , a.AccountType , AccountName , CoaType , AccountHead
	,SUM(CASE 
				
				WHEN t.TransactionDate between  @DateFrom and @DateTo
					AND e.EntryType = 'D'
					THEN e.amount
				ELSE 0.0
				END) AS TotalDebitBefore
		,SUM(CASE 
				WHEN t.TransactionDate   between  @DateFrom and @DateTo
					AND e.EntryType = 'C'
					THEN e.amount
				ELSE 0.0
				END) AS TotalCreditBefore
	
	
		FROM Documents d
	LEFT JOIN Transactions t ON t.DocumentID = d.ID
	LEFT JOIN Ledger_Entries e ON e.TransactionID = t.ID
	LEFT JOIN Accounts a ON a.id = e.AccountID
	where  
	AccountType  in ('Income','Expenses')
	and
	CoaType = 'Transaction'
	group  by    AccountName , AccountType , CoaType ,a.ID , AccountHead
	),
	
	

	 CTEE  as(
	select ID , AccountHead, AccountType ,case when AccountType =   'Expenses'  then    (TotalDebitBefore  - TotalCreditBefore)  else 0 end as Expenses,
	                                       case    when AccountType  =  'Income'   then     (TotalCreditBefore - TotalDebitBefore)    else 0 end as Income
	from cte
	

	)


	select  AccountHead  ,  sum (Income - Expenses)as Profit  , AccountType
	from CTEE
	group  by AccountHead , AccountType
	
	
end 
GO
/****** Object:  StoredProcedure [dbo].[IncomeStatment_CostOfLand]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE procedure [dbo].[IncomeStatment_CostOfLand]
@date1 date ,
@date2 date 
as begin 
set nocount on

	
CREATE TABLE #Accounts(
	[ID] [bigint] NOT NULL,
	[CompanyID] [varchar](20) NULL,
	[AccountName] [varchar](100) NULL,
	[AccountType] [varchar](50) NULL,
	[AccountCode] [varchar](20) NULL,
	[AccountHead] [varchar](50) NULL,
	[CoaType] [varchar](50) NULL,

)
insert into #Accounts ([ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType])
select                 [ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType]  
from Accounts
WHERE AccountCode in ( '401' , '501' )





;WITH cte
AS (
  SELECT e.AccountID, a.AccountName, a.AccountType,
         SUM(CASE WHEN e.EntryType = 'D' THEN e.amount ELSE 0.0 END) AS TotalDebit,
         SUM(CASE WHEN e.EntryType = 'C' THEN e.amount ELSE 0.0 END) AS TotalCredit
  FROM Transactions t
  LEFT JOIN ledger_entries e ON e.TransactionID = t.id
  LEFT JOIN Accounts a ON a.id = e.AccountID
  WHERE 
  t.TransactionDate BETWEEN @date1 AND @date2
   and  
   e.AccountID LIKE '401%' or  e.AccountID LIKE '501%'
  GROUP BY e.AccountID, a.AccountName, a.AccountType
)  
, ctee as (
SELECT AccountID,(AccountName)  , case when AccountID LIKE '401%'then SUM(TotalCredit - TotalDebit)  when AccountID LIKE '501%'  then SUM(TotalDebit - TotalCredit) else 0 end  AS TotalAmount
FROM cte
GROUP BY AccountID, AccountName
--order by AccountID
)
select left (AccountID,6) as AccountID ,pp.AccountHead , SUM (TotalAmount) as Amount
from  ctee ee
join #Accounts pp on left (AccountID,6) = pp.ID
group by left (AccountID,6),pp.AccountHead

drop table #Accounts


	
	
	 end

	
GO
/****** Object:  StoredProcedure [dbo].[IncomeStatment_Dashboard]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE Procedure[dbo].[IncomeStatment_Dashboard]


 
  
@Date  date 
as begin 
declare 
  @columns NVARCHAR(MAX) = '', 
  @sql     NVARCHAR(MAX) = ''

  -- Calculate start and end of the month
declare @DateFrom date = dateadd(month, datediff(month, 0, @Date), 0)
declare @DateTo date = dateadd(month, datediff(month, 0, @Date) + 1, -1)
create table #tempMain (COL money , OP money  , TAX money )

-------------- Executing Income Statment SPs
create table #temp (AccountName varchar (200) , Amount money)
insert into #temp (AccountName,Amount)
EXEC	IncomeStatment_CostOfLand
		@Date1 = @DateFrom,
		@Date2   = @DateTo 

		insert into #tempMain (COL)
		select SUM (Amount) as CostOfLand from #temp
		drop table #temp
		--drop table Temp

create table #temp1 (AccountName varchar (200) , Amount money)
insert into #temp1 (AccountName,Amount)
EXEC	[dbo].[IncomeStatment_OperatingProfit]
		@Date1 = @DateFrom,
		@Date2   = @DateTo 

		insert into #tempMain (OP)
		select SUM (Amount) as OperatingProfit from #temp1
		drop table #temp1

create table #temp2 (AccountName varchar (200) , Amount money)
insert into #temp2 (AccountName,Amount)
EXEC	[dbo].[IncomeStatment_Taxation]
		@Date1 = @DateFrom,
		@Date2   = @DateTo 

-------------------- Insert Income Statment Result in one Table  
		insert into #tempMain (TAX)
		select SUM (Amount) as Taxation from #temp2
		drop table #temp2

------------------using CTE to Pivot the Income Statment Heads
		;with cte as (
		SELECT OP ,'OperatingProfit' as Head
FROM #tempMain
WHERE OP IS NOT NULL

UNION

SELECT  COL , 'CostOfLand' as Head
FROM #tempMain
WHERE COL IS NOT NULL

UNION

SELECT  TAX , 'Taxation' as Head
FROM #tempMain
WHERE TAX IS NOT NULL)



-- select the Head names
SELECT 
    @columns+=QUOTENAME(Head) + ','
FROM 
    cte;

-- remove the last comma
SET @columns = LEFT(@columns, LEN(@columns) - 1);


-- construct dynamic SQL
SET @sql ='
SELECT * FROM   
(
    SELECT OP ,''OperatingProfit'' as Head
FROM #tempMain
WHERE OP IS NOT NULL

UNION

SELECT  COL , ''CostOfLand'' as Head
FROM #tempMain
WHERE COL IS NOT NULL

UNION

SELECT  TAX , ''Taxation'' as Head
FROM #tempMain
WHERE TAX IS NOT NULL
) t 
PIVOT(
    max(OP) 
    FOR Head IN ('+ @columns +')
) AS pivot_table;';

-- execute the dynamic SQL
EXECUTE sp_executesql @sql;
drop table #tempMain
end
GO
/****** Object:  StoredProcedure [dbo].[IncomeStatment_GrossProfit]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE procedure [dbo].[IncomeStatment_GrossProfit]
@date1 date ,
@date2 date 
as begin 
set nocount on


	
CREATE TABLE #Accounts(
	[ID] [bigint] NOT NULL,
	[CompanyID] [varchar](20) NULL,
	[AccountName] [varchar](100) NULL,
	[AccountType] [varchar](50) NULL,
	[AccountCode] [varchar](20) NULL,
	[AccountHead] [varchar](50) NULL,
	[CoaType] [varchar](50) NULL,

)
insert into #Accounts ([ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType])
select                 [ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType]  
from Accounts
WHERE AccountCode in ( '502', '507' , '508', '506', '505', '504', '503', '510')





;WITH cte
AS (
  SELECT e.AccountID, a.AccountName, a.AccountType,
         SUM(CASE WHEN e.EntryType = 'D' THEN e.amount ELSE 0.0 END) AS TotalDebit,
         SUM(CASE WHEN e.EntryType = 'C' THEN e.amount ELSE 0.0 END) AS TotalCredit
  FROM Transactions t
  LEFT JOIN ledger_entries e ON e.TransactionID = t.id
  LEFT JOIN Accounts a ON a.id = e.AccountID
  WHERE 
  t.TransactionDate BETWEEN @date1 AND @date2
   and  
    e.AccountID LIKE '502%'or e.AccountID LIKE '507%'or e.AccountID LIKE '508%'or e.AccountID LIKE '506%'or e.AccountID LIKE '505%'or e.AccountID LIKE '504%'or e.AccountID LIKE '503%'or e.AccountID LIKE '510%'
  GROUP BY e.AccountID, a.AccountName, a.AccountType
)  
, ctee as (
SELECT AccountID,(AccountName)  , SUM(TotalDebit - TotalCredit) AS TotalAmount
FROM cte
GROUP BY AccountID, AccountName
--order by AccountID
)
select left (AccountID,3) as AccountID ,pp.[AccountHead] 
, SUM (TotalAmount) as Amount
from  ctee ee
join #Accounts pp on left (AccountID,3) = left (pp.ID , 3 )
group by left (AccountID,3),pp.[AccountHead]

drop table #Accounts
	
	
	 end

	
GO
/****** Object:  StoredProcedure [dbo].[IncomeStatment_OperatingProfit]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE procedure [dbo].[IncomeStatment_OperatingProfit]
@date1 date ,
@date2 date 
as begin 
set nocount on


	

CREATE TABLE #Accounts(
	[ID] [bigint] NOT NULL,
	[CompanyID] [varchar](20) NULL,
	[AccountName] [varchar](100) NULL,
	[AccountType] [varchar](50) NULL,
	[AccountCode] [varchar](20) NULL,
	[AccountHead] [varchar](50) NULL,
	[CoaType] [varchar](50) NULL,

)
insert into #Accounts ([ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType])
select                 [ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType]  
from Accounts
WHERE AccountCode = '509'





;WITH cte
AS (
  SELECT e.AccountID, a.AccountName, a.AccountType,
         SUM(CASE WHEN e.EntryType = 'D' THEN e.amount ELSE 0.0 END) AS TotalDebit,
         SUM(CASE WHEN e.EntryType = 'C' THEN e.amount ELSE 0.0 END) AS TotalCredit
  FROM Transactions t
  LEFT JOIN ledger_entries e ON e.TransactionID = t.id
  LEFT JOIN Accounts a ON a.id = e.AccountID
  WHERE 
  t.TransactionDate BETWEEN @date1 AND @date2
   and  
   e.AccountID LIKE '509%'
  GROUP BY e.AccountID, a.AccountName, a.AccountType
)  
, ctee as (
SELECT AccountID,(AccountName)  , SUM(TotalDebit - TotalCredit) AS TotalAmount
FROM cte
GROUP BY AccountID, AccountName
--order by AccountID
)
select left (AccountID,3) as AccountID ,pp.[AccountHead] 
, SUM (TotalAmount) as Amount
from  ctee ee
join #Accounts pp on left (AccountID,3) = left (pp.ID , 3 )
group by left (AccountID,3),pp.[AccountHead]

drop table #Accounts

	


	
	
	 end

	
GO
/****** Object:  StoredProcedure [dbo].[IncomeStatment_Taxation]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE procedure [dbo].[IncomeStatment_Taxation]
@date1 date ,
@date2 date 
as begin 
set nocount on


CREATE TABLE #Accounts(
	[ID] [bigint] NOT NULL,
	[CompanyID] [varchar](20) NULL,
	[AccountName] [varchar](100) NULL,
	[AccountType] [varchar](50) NULL,
	[AccountCode] [varchar](20) NULL,
	[AccountHead] [varchar](50) NULL,
	[CoaType] [varchar](50) NULL,

)
insert into #Accounts ([ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType])
select                 [ID], [CompanyID], [AccountName], [AccountType], [AccountCode], [AccountHead], [CoaType]  
from Accounts
WHERE AccountCode = '511'





;WITH cte
AS (
  SELECT e.AccountID, a.AccountName, a.AccountType,
         SUM(CASE WHEN e.EntryType = 'D' THEN e.amount ELSE 0.0 END) AS TotalDebit,
         SUM(CASE WHEN e.EntryType = 'C' THEN e.amount ELSE 0.0 END) AS TotalCredit
  FROM Transactions t
  LEFT JOIN ledger_entries e ON e.TransactionID = t.id
  LEFT JOIN Accounts a ON a.id = e.AccountID
  WHERE 
  --t.TransactionDate BETWEEN @date1 AND @date2
   --and  
   e.AccountID LIKE '511%'
  GROUP BY e.AccountID, a.AccountName, a.AccountType
)  
, ctee as (
SELECT AccountID,(AccountName)  , SUM(TotalDebit - TotalCredit) AS TotalAmount
FROM cte
GROUP BY AccountID, AccountName
--order by AccountID
)
select left (AccountID,3) as AccountID ,pp.[AccountHead] 
, SUM (TotalAmount) as Amount
from  ctee ee
join #Accounts pp on left (AccountID,3) = left (pp.ID , 3 )
group by left (AccountID,3),pp.[AccountHead]

drop table #Accounts

	

	
	
	 end

	
GO
/****** Object:  StoredProcedure [dbo].[Issuance_Report_Itemwise]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Issuance_Report_Itemwise]
@ItemId int ,
@reqid int

as begin 

create table #temp2 (RequisitionId varchar (100) ,DepartmentName varchar (100),ProjectName varchar (100),IssuanceDate date,IssuanceCode varchar (100),itemid int,ItemName varchar (100),IssuanceQuantity decimal (18,2))
insert into #temp2 (RequisitionId,DepartmentName,ProjectName,IssuanceDate,IssuanceCode,ItemId,ItemName,IssuanceQuantity)

select s.RequisitionId,s.DepartmentName,s.ProjectName,s.IssuanceDate,s.IssuanceCode,it.itemId,it.ItemName,it.IssuanceQuantity
from  Issuances     s
join IssuanceItem  it on s.IssuanceId=it.IssuanceId
where it.IssuanceQuantity <> 0
order by RequisitionId
--select * from #temp2
	 
SELECT RequisitionId, itemId,ItemName, SUM(IssuanceQuantity) AS IssuanceQuantity,IssuanceDate
      FROM #temp2
	  where Itemid = @ItemId 
	  and RequisitionId = @reqid


	  GROUP BY RequisitionId, itemId,ItemName,IssuanceDate
	  drop table #temp2
	  end
GO
/****** Object:  StoredProcedure [dbo].[Item_Aging_Report_Issuance]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Item_Aging_Report_Issuance]

@DateFrom date,
@DateTo date,
@Item varchar (100)
as begin






with cte as (
SELECT r.RId,gi.ItemName , g.Dated as EntryDate , s.IssuanceDate as Issuance_Date
  FROM [dbo].[GrnOrder] g
  join [dbo].[GrnOrderItems] gi on g.GrnOrderID= gi.GrnID
  join Requisition r                           on g.ReqID =r.RequisitionId
  join Issuances   s                           on r.RequisitionId = s.RequisitionId
  where ItemName  =  case when @Item ='' then ItemName else @Item end
  and  g.Dated between @DateFrom and @DateTo

  )

  select * , DATEDIFF(DAY ,EntryDate,Issuance_Date ) as Total_Days from cte 
end
GO
/****** Object:  StoredProcedure [dbo].[Item_Consumption_Report_department]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure  [dbo].[Item_Consumption_Report_department]
@department varchar (100),
@project varchar (100),
@item varchar (100),
@datefrom date,
@dateto date
as begin



SELECT   
i.RequisitionId,isi.ItemName , isi.IssuanceQuantity  ,i.DepartmentName , i.ProjectName ,IssuanceDate , cast (it.CostUnit*isi.IssuanceQuantity as money ) as Value
  FROM [dbo].[Issuances] i
  join [dbo].[IssuanceItem] isi on i.IssuanceId=isi.IssuanceId
  join [dbo].[Inventory] it     on isi.itemId  =it.ItemID  and it.Type = 1

  where isi.ItemName=  case when  @item ='' then ItemName else @item end
  and   i.DepartmentName = case when  @department ='' then DepartmentName else @department end
  and   i.ProjectName    = case when  @project='' then ProjectName else @project end
  and   i.IssuanceDate between @datefrom and  @dateto

  group by i.DepartmentName , i.ProjectName , isi.ItemName,i.RequisitionId , IssuanceQuantity , IssuanceDate,it.CostUnit

  end

GO
/****** Object:  StoredProcedure [dbo].[Item_detail_byName]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
	CREATE PROCEDURE [dbo].[Item_detail_byName]
@CompID varchar (50),
@name varchar (150)
AS
BEGIN
	SET NOCOUNT ON
CREATE TABLE #temp (
		id INT
		,qua decimal(19, 3)
		)
	INSERT INTO #temp (
		id
		,qua
		)
	SELECT ItemID
		,sum(Quantity) AS quantity
	FROM Inventory
	WHERE (Type % 2) != 0
	GROUP BY ItemID
	CREATE TABLE #tempp (
		id INT
		,quan decimal(19, 3)
		)
	INSERT INTO #tempp (
		id
		,quan
		)
	SELECT ItemID
		,sum(Quantity) AS Quantity
	FROM Inventory
	WHERE (Type % 2) = 0
	GROUP BY ItemID
	
	SELECT DISTINCT il.Name,il.PurchaseCost,il.ItemCategory , ic.CategoryName
		,i.ItemID , il.ItemCode
		,(t.qua - tt.quan) AS Qty  --il.Name,

into #tempresult 

 FROM Inventory i 
	left JOIN #tempp tt
		ON i.ItemID = tt.id
	left JOIN  #temp t
		ON t.id = i.ItemID --and Type = 1
	INNER JOIN ItemList il
		ON i.ItemID = il.ID
	INNER JOIN ItemCategory ic
	    ON IC.ID = il.ItemCategory
where  il.Name like '%' + @name + '%'



	;with cte  as 
	( 
SELECT  ItemID,
sum (CostUnit)as cu , count (*) as divi 
  FROM [Account_Finance].[dbo].[Inventory]
  where Type = 1
  group by ItemID
  )

  select ItemID , cu /divi as [AVG]
  into #tempvalue
  from cte 

 	


  select t.* ,[AVG]   from #tempresult t
  join #tempvalue v on t.ItemID = v.ItemID
  order by t.Name 



	DROP TABLE #temp
	DROP TABLE #tempp
	DROP TABLE #tempresult
	DROP TABLE #tempvalue
	end



			
GO
/****** Object:  StoredProcedure [dbo].[Item_Issuance_Report_department]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure  [dbo].[Item_Issuance_Report_department]
@department varchar (100),
@project varchar (100),
@item varchar (100),
@datefrom date,
@dateto date
as begin



SELECT   
i.IssuanceDate,i.IssuanceId,i.DepartmentName , i.ProjectName ,i.Status,isi.unit,isi.ItemName , isi.IssuanceQuantity   ,cast (sum( it.CostUnit)* isi.IssuanceQuantity as money )as Value
  FROM [dbo].[Issuances] i
  join [dbo].[IssuanceItem] isi on i.IssuanceId=isi.IssuanceId
  join [dbo].[Inventory] it     on isi.itemId  =it.ItemID  and it.Type = 1

  where isi.ItemName=  case when  @item ='' then ItemName else @item end
  and   i.DepartmentName = case when  @department ='' then DepartmentName else @department end
  and   i.ProjectName    = case when  @project='' then ProjectName else @project end
  and   i.IssuanceDate between @datefrom and  @dateto

  group by i.IssuanceDate,i.IssuanceId,i.DepartmentName , i.ProjectName ,i.Status,isi.unit,isi.ItemName , isi.IssuanceQuantity  ,isi.IssuanceQuantity 



  end

GO
/****** Object:  StoredProcedure [dbo].[Joining_Item_Costvalue]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
	CREATE procedure [dbo].[Joining_Item_Costvalue]
	@comp varchar (50)
	as begin
	create Table #temp (Name varchar (250),PurchaseCost int,ItemCategory int , CategoryName varchar(250)
		,ItemID int
		,Qty decimal(19, 3), Cost  decimal(19, 3))
		insert into #temp  (Name ,PurchaseCost ,ItemCategory  , CategoryName ,ItemID  ,Qty  )
		exec [dbo].[RemainingItem] @comp
		--select * from #temp
		create Table #tempp ( [ItemID] int  , CostValue  decimal(19, 3)   )
		insert into #tempp ([ItemID],CostValue)
		exec Get_Item_AverageCostValue @comp
				--select * from #tempp
		update #temp
		set Cost = CostValue
		from #temp t
		join #tempp tt on t.ItemID= tt.ItemID
		select * from #temp
		drop table #temp
		drop table #tempp
		end
GO
/****** Object:  StoredProcedure [dbo].[Joining_RemainingItem_AVGCostvalue]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
	CREATE procedure [dbo].[Joining_RemainingItem_AVGCostvalue]

	@comp varchar (50)
	as begin 

	create Table #temp (Name varchar (250),PurchaseCost int,ItemCategory int , CategoryName varchar(250)
		,ItemID int 
		,Qty decimal(19, 3), Cost  decimal(19, 3))

		insert into #temp  (Name ,PurchaseCost ,ItemCategory  , CategoryName ,ItemID  ,Qty  )
		exec [dbo].[RemainingItem] @comp
		--select * from #temp

		create Table #tempp ( [ItemID] int  , CostValue  decimal(19, 3)   )
		insert into #tempp ([ItemID],CostValue)
		exec Get_Item_AverageCostValue @comp
			--	select * from #tempp



		update #temp
		set Cost = CostValue 
		from #temp t
		join #tempp tt on t.ItemID= tt.ItemID
		select * from #temp
		drop table #temp
		drop table #tempp

		end 
GO
/****** Object:  StoredProcedure [dbo].[Ledger_Check]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Ledger_Check]
as begin 
;with temp as (
SELECT c.TransactionID, sum(c.amount) as 'C-sum', d.[D-sum]
  FROM [Account_Finance].[dbo].[Ledger_Entries] as c
  inner join (SELECT TransactionID, sum(amount) as 'D-sum'
  FROM [Account_Finance].[dbo].[Ledger_Entries]
  where EntryType = 'D'
  group by TransactionID) as d
  on d.TransactionID = c.TransactionID
  where c.EntryType = 'C'
  group by c.TransactionID, d.[D-sum]
  )
  select * from temp
  where [C-sum]-[D-sum] > 1.00 or [D-sum]-[C-sum] > 1.00
  order by TransactionID
  end
GO
/****** Object:  StoredProcedure [dbo].[Ledger_Report_PB]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create procedure [dbo].[Ledger_Report_PB]
 
@Start_date date ,
@comp varchar (100) ,
@ID bigint 

	


		as begin 
		set nocount on
		
	
	
	create table #temp ( RowNumber int ,AccountID bigint	,DocumentNo varchar (100),AccountName varchar (200),TransactionDate date , Description varchar (500) , AccountType varchar (100) , Debit  money , Credit money )
	;WITH cte
	AS (
		SELECT d.DocumentNo,e.AccountID, a.AccountName,t.TransactionDate,t.Description as Description,AccountType
			,SUM(CASE
					WHEN e.EntryType = 'D'
						THEN e.amount
					ELSE 0.0
					END) AS TotalDebit
			,SUM(CASE
					WHEN e.EntryType = 'C'
						THEN e.amount
					ELSE 0.0
					END) AS TotalCredit
		FROM Transactions t
		left join Documents d on t.DocumentID = d.ID
		LEFT JOIN ledger_entries e ON e.TransactionID = t.id
		LEFT JOIN Accounts a ON a.id = e.AccountID
		WHERE
		t.TransactionDate < @Start_date
		and
			e.AccountID like concat (@ID ,'%')
		AND a.CompanyID = @comp
		GROUP BY d.DocumentNo,e.AccountID, a.AccountName,t.TransactionDate,t.Description,AccountType
		)  
	
	insert into #temp (RowNumber ,DocumentNo,AccountID, AccountName,TransactionDate,Description,AccountType ,Debit , Credit)
	
		select  ROW_NUMBER() OVER (ORDER BY (TransactionDate  )) AS RowNumber,DocumentNo,AccountID, AccountName,TransactionDate,Description,AccountType,
	case when 	AccountType  in ('Assets' , 'Equity' , 'Expenses')  then (TotalDebit  - TotalCredit) else 0.0 end as Debit,
    case when 	AccountType  in ('Liabilities' , 'Income' )         then (TotalCredit - TotalDebit)  else 0.0 end as Credit
	 from cte
	 order by TransactionDate


	begin 
		 update #temp 
		 set Credit = Debit  , debit = Credit
		 where AccountType  in ('Assets' , 'Equity' , 'Expenses')  and sign (Debit)= -1  

		  update #temp 
		 set Debit  = Credit  , Credit = Debit
		 where AccountType  in ('Liabilities' , 'Income' )   and sign (Credit)= -1  
	 end 

	 ;with ctee as (
		 select 	RowNumber,	 
		 DocumentNo,AccountID, AccountName,TransactionDate,Description,AccountType,
		 case when  sign (Debit)= -1   then abs( Debit ) else  Debit end as Debit , 		 case when  sign (Credit)= -1   then abs( Credit ) else  Credit end as Credit 
		 from  #temp),

		 cteee as 
		 ( 

		 select *,
		 sum(Debit- Credit)   over (order by   RowNumber RANGE UNBOUNDED PRECEDING) as balance ,'Cr' as [Post]
		 from ctee
		 )

		   select RowNumber ,DocumentNo ,AccountID ,AccountName , TransactionDate , Description , AccountType , Debit , Credit  ,  ABS(balance) as balance,
		   case when  balance >= 0    then 'Dr' when balance <= 0  then 'Cr' end as Post
		  from cteee 
		order by RowNumber






		 drop table #temp
		



	end 

GO
/****** Object:  StoredProcedure [dbo].[LedgerReport]    Script Date: Saturday, 11-Mar-2023 11:55:43 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[LedgerReport]


@startdate date  --= '2022-01-01' , 
 ,
@enddate  date  --='2022-12-20', 
 ,
@compa varchar (100)  --= '632462982ad6e',
,
@Id bigint  --= '101001'
--bigint

as begin 

if
@Id like '1%' or @Id like '3%' or @Id like '5%'

begin 
Exec   LedgerReport1
@start_date  =@startdate ,
@end_date =@enddate ,
@comp =@compa,
@ID =@Id
end
else
begin
Exec   LedgerReport2
@start_date  =@startdate ,
@end_date =@enddate ,
@comp =@compa,
@ID =@Id
end 
end
GO
/****** Object:  StoredProcedure [dbo].[LedgerReport1]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE procedure [dbo].[LedgerReport1]
@start_date date ,
@end_date date ,
@comp varchar (100),
@ID bigint

		as begin set nocount on
		
	
	
	create table #temp ( RowNumber int ,AccountID bigint	,DocumentNo varchar (100),AccountName varchar (100),TransactionDate date , Description varchar (500) , AccountType varchar (100) , Debit  money , Credit money )
	;WITH cte
	AS (
		SELECT d.DocumentNo,e.AccountID, a.AccountName,t.TransactionDate,t.Description,AccountType
			,SUM(CASE
					WHEN e.EntryType = 'D'
						THEN e.amount
					ELSE 0.0
					END) AS TotalDebit
			,SUM(CASE
					WHEN e.EntryType = 'C'
						THEN e.amount
					ELSE 0.0
					END) AS TotalCredit
		FROM Transactions t
		left join Documents d on t.DocumentID = d.ID
		LEFT JOIN ledger_entries e ON e.TransactionID = t.id
		LEFT JOIN Accounts a ON a.id = e.AccountID
		WHERE
		t.TransactionDate BETWEEN @start_date and @end_date
		and
			e.AccountID like concat (@ID ,'%')
		AND a.CompanyID = @comp
		GROUP BY d.DocumentNo,e.AccountID, a.AccountName,t.TransactionDate,t.Description,AccountType
		)  
	
	insert into #temp (RowNumber ,DocumentNo,AccountID, AccountName,TransactionDate,Description,AccountType ,Debit , Credit)
	
		select  ROW_NUMBER() OVER (ORDER BY TransactionDate ) AS RowNumber,DocumentNo,AccountID, AccountName,TransactionDate,Description,AccountType,
	case when 	AccountType  in ('Assets' , 'Equity' , 'Expenses')  then (TotalDebit  - TotalCredit) else 0.0 end as Debit,
    case when 	AccountType  in ('Liabilities' , 'Income' )         then (TotalCredit - TotalDebit)  else 0.0 end as Credit
	 from cte


	begin 
		 update #temp 
		 set Credit = Debit  , debit = Credit
		 where AccountType  in ('Assets' , 'Equity' , 'Expenses')  and sign (Debit)= -1  

		  update #temp 
		 set Debit  = Credit  , Credit = Debit
		 where AccountType  in ('Liabilities' , 'Income' )   and sign (Credit)= -1  
	 end 

	 ;with ctee as (
		 select 	RowNumber,	 
		 DocumentNo,AccountID, AccountName,TransactionDate,Description,AccountType,
		 case when  sign (Debit)= -1   then abs( Debit ) else  Debit end as Debit , 		 case when  sign (Credit)= -1   then abs( Credit ) else  Credit end as Credit 
		 from  #temp)

		 select *,
		 sum(Debit-Credit)   over (order by   RowNumber RANGE UNBOUNDED PRECEDING) as balance
		 from ctee
		 order by TransactionDate, DocumentNo






		 drop table #temp
		



	end 

GO
/****** Object:  StoredProcedure [dbo].[LedgerReport2]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE procedure [dbo].[LedgerReport2]
@start_date date ,
@end_date date ,
@comp varchar (100),
@ID bigint

		as begin set nocount on
		
	
	
	create table #temp ( RowNumber int ,AccountID bigint	,DocumentNo varchar (100),AccountName varchar (100),TransactionDate date , Description varchar (500) , AccountType varchar (100) , Debit  money , Credit money )
	;WITH cte
	AS (
		SELECT d.DocumentNo,e.AccountID, a.AccountName,t.TransactionDate,t.Description,AccountType
			,SUM(CASE
					WHEN e.EntryType = 'D'
						THEN e.amount
					ELSE 0.0
					END) AS TotalDebit
			,SUM(CASE
					WHEN e.EntryType = 'C'
						THEN e.amount
					ELSE 0.0
					END) AS TotalCredit
		FROM Transactions t
		left join Documents d on t.DocumentID = d.ID
		LEFT JOIN ledger_entries e ON e.TransactionID = t.id
		LEFT JOIN Accounts a ON a.id = e.AccountID
		WHERE
		t.TransactionDate BETWEEN @start_date and @end_date
		and
			e.AccountID like concat (@ID ,'%')
		AND a.CompanyID = @comp
		GROUP BY d.DocumentNo,e.AccountID, a.AccountName,t.TransactionDate,t.Description,AccountType
		)  
	
	insert into #temp (RowNumber ,DocumentNo,AccountID, AccountName,TransactionDate,Description,AccountType ,Debit , Credit)
	
		select  ROW_NUMBER() OVER (ORDER BY Transactiondate) AS RowNumber,DocumentNo,AccountID, AccountName,TransactionDate,Description,AccountType,
	case when 	AccountType  in ('Assets' , 'Equity' , 'Expenses')  then (TotalDebit  - TotalCredit) else 0.0 end as Debit,
    case when 	AccountType  in ('Liabilities' , 'Income' )         then (TotalCredit - TotalDebit)  else 0.0 end as Credit
	 from cte


	begin 
		 update #temp 
		 set Credit = Debit  , debit = Credit
		 where AccountType  in ('Assets' , 'Equity' , 'Expenses')  and sign (Debit)= -1  

		  update #temp 
		 set Debit  = Credit  , Credit = Debit
		 where AccountType  in ('Liabilities' , 'Income' )   and sign (Credit)= -1  
	 end 

	 ;with ctee as (
		 select 	RowNumber 
		 ,DocumentNo,AccountID, AccountName,TransactionDate,Description,AccountType,
		 case when  sign (Debit)= -1   then abs( Debit ) else  Debit end as Debit , 		 case when  sign (Credit)= -1   then abs( Credit ) else  Credit end as Credit 
		 from  #temp)

		 select *,
		 sum(Credit-Debit)   over (order by   RowNumber RANGE UNBOUNDED PRECEDING) as balance
		 from ctee
		 order by TransactionDate,DocumentNo
		 



		 drop table #temp
		



	end 
GO
/****** Object:  StoredProcedure [dbo].[Material_ReceivedAND_Issuance_Report]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Material_ReceivedAND_Issuance_Report]
@department varchar (100),
@project varchar (100),
@datefrom date ,
@dateto date 

as begin 


create table #temp (RId varchar(50),Dated date ,ReqID int ,Status varchar (100),GrnID varchar (100),ItemId int ,ItemName varchar (100),PoQuantity bigint,Price money,RecvdQuantity decimal (18,2) ) 
insert into  #temp (RId,Dated,ReqID,Status,GrnID,ItemId,ItemName,PoQuantity,Price,RecvdQuantity )
select r.RId,r.Dated,g.ReqID,g.Status,g.GrnID,gi.ItemId,gi.ItemName,gi.PoQuantity,gi.Price,gi.RecvdQuantity 
--,s.DepartmentName,s.ProjectName,s.IssuanceDate,s.IssuanceCode,it.ItemName,it.IssuanceQuantity
from GrnOrder g
join GrnOrderItems gi on g.GrnOrderID=gi.GrnID
join Requisition   r  on r.RequisitionId =g.ReqID
where gi.RecvdQuantity <> 0
order by g.ReqID
--select * from #temp
--order by  ReqID



create table #temp2 (RequisitionId varchar (100) ,DepartmentName varchar (100),ProjectName varchar (100),IssuanceDate date,IssuanceCode varchar (100),itemid int,ItemName varchar (100),IssuanceQuantity decimal (18,2))
insert into #temp2 (RequisitionId,DepartmentName,ProjectName,IssuanceDate,IssuanceCode,ItemId,ItemName,IssuanceQuantity)

select r.RId,s.DepartmentName,s.ProjectName,r.Dated,s.IssuanceCode,it.itemId,it.ItemName,it.IssuanceQuantity
from  Issuances     s
join IssuanceItem  it on s.IssuanceId=it.IssuanceId
join Requisition   r  on r.RequisitionId =s.RequisitionId

where it.IssuanceQuantity <> 0
order by r.RId
--select * from #temp2



SELECT t.RId, t.ReqID, t2.DepartmentName, t2.ProjectName,t.ItemId ,t.ItemName, t.RecvdQuantity, t2.IssuanceQuantity,t.Price, t.Dated ,(RecvdQuantity*Price) as Costvalue
FROM (SELECT RId,ReqID,ItemId ,ItemName, SUM(RecvdQuantity) AS RecvdQuantity,Dated,Avg(Price) as Price
      FROM #temp
      GROUP BY ReqID,RId, ItemId,ItemName,Dated
	  ) t
JOIN (SELECT RequisitionId, ItemId,ItemName, SUM(IssuanceQuantity) AS IssuanceQuantity,DepartmentName, ProjectName--,IssuanceDate
      FROM #temp2
      GROUP BY RequisitionId,ItemId ,ItemName,DepartmentName, ProjectName--,IssuanceDate
	  ) t2
ON  t.RId = t2.RequisitionId AND t.ItemName = t2.ItemName
where t2.DepartmentName = case when  @department ='' then t2.DepartmentName else @department end
and t2.ProjectName      = case when  @project    ='' then t2.ProjectName    else @project    end
and t.Dated between @datefrom and @dateto

;
drop table #temp
drop table #temp2
end
GO
/****** Object:  StoredProcedure [dbo].[Material_ReceivedReport_Itemwise]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[Material_ReceivedReport_Itemwise]

@ItemID varchar (100),
@reqid int 

as begin 


create table #temp (Dated date ,ReqID int ,Status varchar (100),GrnID varchar (100),ItemId int ,ItemName varchar (100),PoQuantity bigint,Price money,RecvdQuantity decimal (18,2) ) 
insert into  #temp (Dated,ReqID,Status,GrnID,ItemId,ItemName,PoQuantity,Price,RecvdQuantity )
select g.Dated,g.ReqID,g.Status,g.GrnID,gi.ItemId,gi.ItemName,gi.PoQuantity,gi.Price,gi.RecvdQuantity 
from GrnOrder g
join GrnOrderItems gi on g.GrnOrderID=gi.GrnID
where gi.RecvdQuantity <> 0
order by g.ReqID

SELECT ReqID,ItemId ,ItemName, SUM(RecvdQuantity) AS RecvdQuantity,Dated
      FROM #temp

where ItemId = @ItemID 
and ReqID = @reqid
      GROUP BY ReqID, ItemId ,ItemName,Dated
drop table #temp
end
GO
/****** Object:  StoredProcedure [dbo].[Nodeledger_remainingbalance]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE Procedure [dbo].[Nodeledger_remainingbalance]
@Datefrom datetime,
@DateTo datetime,
@id bigint,
@compid varchar (50)
as begin
  create table #temp ( code bigint ,name varchar(50) , amount decimal (20,2) )
;with cte as (
SELECT  e.AccountID, a.AccountName,AccountType, 
SUM(CASE WHEN e.EntryType='D'
         THEN e.amount ELSE 0.0 END) AS TotalDebit,
SUM(CASE WHEN  e.EntryType='C'
         THEN e.amount ELSE 0.0 END) AS TotalCredit
FROM Transactions t
LEFT JOIN ledger_entries e ON e.TransactionID = t.id
LEFT JOIN Accounts a ON a.id = e.AccountID
WHERE t.TransactionDate between @Datefrom and @DateTo
and a.AccountCode like concat (@id ,'%')
and a.CompanyID = @Compid
GROUP BY e.AccountID ,a.AccountName , AccountType
       --ORDER BY CAST(e.AccountID AS CHAR)
	   )
	
	   insert into #temp (code,name,amount)
	   select AccountID, AccountName, case when AccountType in ('Liability', 'Expense') then  sum (TotalCredit -TotalDebit) else sum (TotalDebit - TotalCredit) end  as am from cte
	   GROUP BY AccountID ,AccountName , AccountType
	   select  sum  (amount)  as 'TotalAmount' from #temp t
	                                                         --join Accounts a on t.code = a.AccountCode
	                                                          -- where a.AccountCode like '201001%'
	                                                          --GROUP BY a.AccountName
	   drop table #temp
end
GO
/****** Object:  StoredProcedure [dbo].[Project_Link_Department]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

create procedure [dbo].[Project_Link_Department]
@CompanyID varchar (50),
@department varchar (50)

as
begin
select d.DepartmentName , p.ProjectName from DepartmentProject d
join ProjectLinkCoa p on d.ProjectID =p.ID
where p.CoaID is not null
and d.CompanyID = @CompanyID
and d.DepartmentName = @department

end
GO
/****** Object:  StoredProcedure [dbo].[RemainingAssets]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[RemainingAssets]
@CompID varchar (50)

AS
BEGIN
	SET NOCOUNT ON
	CREATE TABLE #temp (
		id varchar(50)
		,qua INT
		)
	INSERT INTO #temp (
		id
		,qua
		)
	SELECT  AssetsUniqueID
		,sum(Quantity) AS quantity
	FROM Assets
	WHERE (AssetType % 2) != 0
	GROUP BY AssetsUniqueID 
	

	CREATE TABLE #tempp (
		id varchar (50)
		,quan INT
		)
	INSERT INTO #tempp (
		id
		,quan
		)
	SELECT AssetsUniqueID
		,sum(Quantity) AS Quantity
	FROM Assets
	WHERE (AssetType % 2) = 0
	GROUP BY AssetsUniqueID

	select distinct i.Name,i.PurchaseCost,i.ItemCategory , c.CategoryName
		,a.AssetsUniqueID
		,(t.qua - tt.quan) AS Qty 
	FROM #temp t
	INNER JOIN #tempp tt
		ON t.id = tt.id
	join  Assets a
	on a.AssetsUniqueID = tt.id
	join ItemList i
	on i.ID = a.AssetID
	join ItemCategory c
	on  c.ID = i.ItemCategory
	 where  i.CompanyID = @compID


	DROP TABLE #temp
	DROP TABLE #tempp
	end
GO
/****** Object:  StoredProcedure [dbo].[RemainingAssets_CategoryWi]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure [dbo].[RemainingAssets_CategoryWi]
as begin 

create table #AssetIN ( ID int ,Name varchar(100) ,CategoryName varchar (100) , TotalAssets  int )
insert into #AssetIN  ( ID,Name,CategoryName ,TotalAssets )

(select                 i.ID,i.Name,c.CategoryName ,SUM (Quantity) TotalAssets 
from Assets a
join ItemList i on a.AssetID=i.ID and i.ItemType = 'Assets'
join ItemCategory c on i.ItemCategory = c.ID
where   (AssetType % 2) != 0
group by i.ID,i.Name,c.CategoryName )



create table #Assetout ( ID int ,Name varchar (100) ,CategoryName varchar (100) , AssignedAssets  int )
insert into #Assetout  ( ID,Name,CategoryName ,AssignedAssets ) 

(select i.ID,i.Name,c.CategoryName ,SUM (Quantity) AssignedAssets 
from Assets a
join ItemList i on a.AssetID=i.ID and i.ItemType = 'Assets'
join ItemCategory c on i.ItemCategory = c.ID
where  (AssetType % 2) = 0
group by i.ID,i.Name,c.CategoryName )


select a.Name , a.CategoryName,a.TotalAssets ,(a.TotalAssets - o.AssignedAssets) AvailableAsset 
from #AssetIN a 
join #Assetout o on a.ID= o.ID

drop table #AssetIN
drop table #Assetout

end 

GO
/****** Object:  StoredProcedure [dbo].[RemainingAssets_Dashboard]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

create PROCEDURE [dbo].[RemainingAssets_Dashboard]
@CompID varchar (50) ,
@Name varchar (100)

AS
BEGIN
	SET NOCOUNT ON
	CREATE TABLE #temp (
		id varchar(50)
		,qua INT
		)
	INSERT INTO #temp (
		id
		,qua
		)
	SELECT  AssetsUniqueID
		,sum(Quantity) AS quantity
	FROM Assets
	WHERE (AssetType % 2) != 0
	GROUP BY AssetsUniqueID 
	

	CREATE TABLE #tempp (
		id varchar (50)
		,quan INT
		)
	INSERT INTO #tempp (
		id
		,quan
		)
	SELECT AssetsUniqueID
		,sum(Quantity) AS Quantity
	FROM Assets
	WHERE (AssetType % 2) = 0
	GROUP BY AssetsUniqueID

	select distinct i.Name,i.PurchaseCost,i.ItemCategory , c.CategoryName
		,a.AssetsUniqueID
		,(t.qua - tt.quan) AS Qty 
	FROM #temp t
	INNER JOIN #tempp tt
		ON t.id = tt.id
	join  Assets a
	on a.AssetsUniqueID = tt.id
	join ItemList i
	on i.ID = a.AssetID
	join ItemCategory c
	on  c.ID = i.ItemCategory
	 where  i.CompanyID = @compID
	 and i.Name like concat  (@Name , '%%') 

	DROP TABLE #temp
	DROP TABLE #tempp
	end
GO
/****** Object:  StoredProcedure [dbo].[RemainingAssetsCount]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

create PROCEDURE [dbo].[RemainingAssetsCount]
--@CompID varchar (50)

AS
BEGIN
SET NOCOUNT ON
	CREATE TABLE #temp (
		id varchar(50)
		,qua INT
		)
	INSERT INTO #temp (
		id
		,qua
		)
	SELECT  AssetsUniqueID
		,sum(Quantity) AS quantity
	FROM Assets
	WHERE (AssetType % 2) != 0
	GROUP BY AssetsUniqueID 
	

	CREATE TABLE #tempp (
		id varchar (50)
		,quan INT
		)
	INSERT INTO #tempp (
		id
		,quan
		)
	SELECT AssetsUniqueID
		,sum(Quantity) AS Quantity
	FROM Assets
	WHERE (AssetType % 2) = 0
	GROUP BY AssetsUniqueID


	;with cte as (
	select distinct i.Name 
	--,COUNT (i.Name) as TotalProduct
		, sum (t.qua - tt.quan) AS AvailableStock  
	FROM #temp t
	INNER JOIN #tempp tt
		ON t.id = tt.id
	join  Assets a
	on a.AssetsUniqueID = tt.id
	join ItemList i
	on i.ID = a.AssetID
	group by   i.Name
	)

	select  COUNT (Name) as AvailablelProdect , SUM (AvailableStock)as stockQuantity
	from cte 
	where AvailableStock >0
		--group by   Name,AvailableStock

	DROP TABLE #temp
	DROP TABLE #tempp
END
GO
/****** Object:  StoredProcedure [dbo].[RemainingItem]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE   [dbo].[RemainingItem] 
@CompID varchar (50)
AS
BEGIN
	SET NOCOUNT ON
	
	CREATE TABLE #temp (
		id INT
		,qua decimal(19, 3)
		)
	INSERT INTO #temp (
		id
		,qua
		)
	SELECT ItemID
		,sum(Quantity) AS quantity
	FROM Inventory
	WHERE (Type % 2) != 0
	GROUP BY ItemID
	CREATE TABLE #tempp (
		id INT
		,quan decimal(19, 3)
		)
	INSERT INTO #tempp (
		id
		,quan
		)
	SELECT ItemID
		,sum(Quantity) AS Quantity
	FROM Inventory
	WHERE (Type % 2) = 0
	GROUP BY ItemID
	
	SELECT DISTINCT il.Name,il.PurchaseCost,il.ItemCategory , ic.CategoryName  , AVG (i.CostUnit) as CostUnit
		,i.ItemID , il.ItemCode
		,(t.qua - tt.quan) AS Qty  --il.Name,

into #tempresult 

 FROM Inventory i 
	left JOIN #tempp tt
		ON i.ItemID = tt.id
	left JOIN  #temp t
		ON t.id = i.ItemID --and Type = 1
	INNER JOIN ItemList il
		ON i.ItemID = il.ID
	INNER JOIN ItemCategory ic
	    ON IC.ID = il.ItemCategory
		where i.CompanyID = @CompID
		group by  il.Name,il.PurchaseCost,il.ItemCategory , ic.CategoryName  
		,i.ItemID , il.ItemCode,
		t.qua , tt.quan
		



	;with cte  as 
	( 
SELECT  ItemID,
sum (CostUnit)as cu , count (*) as divi 
  FROM [Inventory]
  where Type = 1
  group by ItemID
  )

  select ItemID ,  (cu /divi )as [AVG]
  into #tempvalue
  from cte 

 	


  select t.* ,[AVG]   from #tempresult t
  join #tempvalue v on t.ItemID = v.ItemID
  order by t.Name 



	DROP TABLE #temp
	DROP TABLE #tempp
	DROP TABLE #tempresult
	DROP TABLE #tempvalue
	end
GO
/****** Object:  StoredProcedure [dbo].[RemainingItem_Categorywise]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create procedure  [dbo].[RemainingItem_Categorywise]
@id int ,
@compID varchar (50)
as begin
set nocount on
  create table #temp (id int , qua decimal(19, 3))
   insert into #temp(id  , qua )
  select ItemID ,sum (Quantity) as quantity from Inventory where (Type % 2) != 0
  group by ItemID
    create table #tempp (id int , quan decimal(19, 3))
   insert into #tempp(id  , quan )
   select ItemID ,sum (Quantity) as Quantity from Inventory where (Type % 2) = 0
  group by ItemID
  select distinct il.Name,i.ItemID , (t.qua-tt.quan) as Remaining   --il.Name,
  from #temp t
   join Inventory i on t.id = i.ItemID
    join #tempp tt on tt.id = i.ItemID
   join ItemList il on i.ItemID = il.ID
   where il.[ItemCategory] = @id and i.CompanyID = @compID
  drop table #temp
  drop table #tempp
end
GO
/****** Object:  StoredProcedure [dbo].[RemainingItem_companywise]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure  [dbo].[RemainingItem_companywise]
@id int ,
@compID varchar (50)
as begin
set nocount on
  create table #temp (id int , qua decimal(19, 3))
   insert into #temp(id  , qua )
  select ItemID ,sum (Quantity) as quantity from Inventory where (Type % 2) != 0
  group by ItemID
    create table #tempp (id int , quan decimal(19, 3))
   insert into #tempp(id  , quan )
   select ItemID ,sum (Quantity) as Quantity from Inventory where (Type % 2) = 0
  group by ItemID
  select distinct il.Name,i.ItemID , (t.qua-tt.quan) as Remaining   --il.Name,
  from #temp t
   join Inventory i on t.id = i.ItemID
    join #tempp tt on tt.id = i.ItemID
   join ItemList il on i.ItemID = il.ID
   where i.ItemID = @id and i.CompanyID = @compID
  drop table #temp
  drop table #tempp
end
GO
/****** Object:  StoredProcedure [dbo].[Stock_Value_Sum]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE procedure   [dbo].[Stock_Value_Sum]
as begin 

set nocount on 
create table #temp  (ItemCategory int,
			CategoryName varchar (100)
			,costunit money
			,Name varchar (100)
			,ItemCode varchar (100)
			, PurchaseCost int
			,ItemID int
			,Qty decimal(10,2)
			, [AVG] money)
insert into #temp (
			
			Name
			, PurchaseCost
			,ItemCategory
			,CategoryName
			,costunit
			,ItemID
			,ItemCode
			,Qty
			, [AVG])


exec  [dbo].[RemainingItem] N'632462982ad6e'

;with cte as (
select (sum ([AVG]) * sum (Qty))as Total , Name  
from #temp
group by Name
)
select SUM (Total) as Total from cte 
end
GO
/****** Object:  StoredProcedure [dbo].[TopAssetCategory_Inventory]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[TopAssetCategory_Inventory]
@CompID varchar (50)
AS
BEGIN
	SET NOCOUNT ON
	CREATE TABLE #temp (
		id INT
		,qua INT
		)
	INSERT INTO #temp (
		id
		,qua
		)
	SELECT il.ItemCategory
		,sum(i.Quantity) AS quantity
	FROM Assets i
	INNER JOIN ItemList il
		ON i.AssetID = il.ID
	WHERE (i.AssetType % 2) != 0
	and il.ItemType ='Assets'
	GROUP BY il.ItemCategory
	CREATE TABLE #tempp (
		id INT
		,quan INT
		)
	INSERT INTO #tempp (
		id
		,quan
		)
	SELECT il.ItemCategory
		,sum(Quantity) AS Quantity
	FROM Assets i
	INNER JOIN ItemList il
		ON i.AssetID = il.ID
	WHERE (AssetType % 2) = 0
		and il.ItemType ='Assets'
	GROUP BY il.ItemCategory
	SELECT DISTINCT 
	
	 ic.CategoryName
		,ic.[ShortCode]
		,(t.qua - tt.quan) AS Qty --il.Name,
	FROM #temp t
	INNER JOIN #tempp tt
		ON t.id = tt.id
	INNER JOIN ItemList il
		ON  tt.id =il.ItemCategory 
	INNER JOIN ItemCategory ic
	    ON IC.ID = il.ItemCategory
		--where --i.CompanyID = @CompID
		
		order by Qty desc
	DROP TABLE #temp
	DROP TABLE #tempp
END


GO
/****** Object:  StoredProcedure [dbo].[TopCategory_Inventory]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[TopCategory_Inventory]
@CompID varchar (50)
AS
BEGIN
	SET NOCOUNT ON
	CREATE TABLE #temp (
		id INT
		,qua INT
		)
	INSERT INTO #temp (
		id
		,qua
		)
	SELECT il.ItemCategory
		,sum(i.Quantity) AS quantity
	FROM Inventory i
	INNER JOIN ItemList il
		ON i.ItemID = il.ID
	WHERE (i.Type % 2) != 0
	GROUP BY il.ItemCategory
	CREATE TABLE #tempp (
		id INT
		,quan INT
		)
	INSERT INTO #tempp (
		id
		,quan
		)
	SELECT il.ItemCategory
		,sum(Quantity) AS Quantity
	FROM Inventory i
	INNER JOIN ItemList il
		ON i.ItemID = il.ID
	WHERE (Type % 2) = 0
	GROUP BY il.ItemCategory
	SELECT DISTINCT 
	
	 ic.CategoryName
		,ic.[ShortCode]
		,(t.qua - tt.quan) AS Qty --il.Name,
	FROM #temp t
	INNER JOIN #tempp tt
		ON t.id = tt.id
	INNER JOIN ItemList il
		ON  tt.id =il.ItemCategory 
	INNER JOIN ItemCategory ic
	    ON IC.ID = il.ItemCategory
		where --i.CompanyID = @CompID
		il.ItemType ='Goods'
		order by Qty desc
	DROP TABLE #temp
	DROP TABLE #tempp
END
GO
/****** Object:  StoredProcedure [dbo].[TopConsumedItem]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
  CREATE Procedure [dbo].[TopConsumedItem]
  as
  begin

  select top (3) l.Name,Sum (i.Quantity) as TotalConsumed
  from [Inventory] i
  join [ItemList] l on i.ItemID = l.ID
  where i.Type = 2
  group by l.Name
  order by TotalConsumed desc
  end
GO
/****** Object:  StoredProcedure [dbo].[TopCustomer]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[TopCustomer]  
@compid VARCHAR(50)

as begin 

select  top (3) c.CustomerName, count (s.CustomerID) as TotalOrder from SalesInvoice s
join Customer c on s.CustomerID = c.CustomerID where s.CompanyID = @Compid
  group by c.CustomerName order by TotalOrder DESC
  end
GO
/****** Object:  StoredProcedure [dbo].[TopItem]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[TopItem]
@CompID varchar (50)
AS
BEGIN
	SET NOCOUNT ON
	CREATE TABLE #temp (
		id INT
		,qua INT
		)
	INSERT INTO #temp (
		id
		,qua
		)
	SELECT ItemID
		,sum(Quantity) AS quantity
	FROM Inventory
	WHERE (Type % 2) != 0
	GROUP BY ItemID
	CREATE TABLE #tempp (
		id INT
		,quan INT
		)
	INSERT INTO #tempp (
		id
		,quan
		)
	SELECT ItemID
		,sum(Quantity) AS Quantity
	FROM Inventory
	WHERE (Type % 2) = 0
	GROUP BY ItemID
	SELECT DISTINCT 
	top (3 ) 
	il.Name, ic.CategoryName
		,i.ItemID
		,(t.qua - tt.quan) AS Qty --il.Name,
	FROM #temp t
	INNER JOIN #tempp tt
		ON t.id = tt.id
	INNER JOIN Inventory i
		ON tt.id = i.ItemID
	INNER JOIN ItemList il
		ON i.ItemID = il.ID
	INNER JOIN ItemCategory ic
	    ON IC.ID = il.ItemCategory
		--where i.CompanyID = @CompID
		order by Qty desc
	DROP TABLE #temp
	DROP TABLE #tempp
END
GO
/****** Object:  StoredProcedure [dbo].[TopVendor]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[TopVendor]  
@compid VARCHAR(50)

as begin 

select  top (3)VendorName, count (VendorName)as TotalOrder from [PurchaseOrder] where CompanyID = @Compid
  group by VendorName  order by TotalOrder DESC
  end
GO
/****** Object:  StoredProcedure [dbo].[TrialBalance]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[TrialBalance] @Datefrom DATETIME
	,@DateTo DATETIME
	--,@id BIGINT
	,@compid VARCHAR(50)
AS
BEGIN
	

	WITH cte
	AS (
		SELECT e.AccountID
			,a.AccountName
			,SUM(CASE 
					WHEN e.EntryType = 'D'
						THEN e.amount
					ELSE 0.0
					END) AS TotalDebit
			,SUM(CASE 
					WHEN e.EntryType = 'C'
						THEN e.amount
					ELSE 0.0
					END) AS TotalCredit
		FROM Transactions t
		LEFT JOIN ledger_entries e ON e.TransactionID = t.id
		LEFT JOIN Accounts a ON a.id = e.AccountID
		WHERE t.TransactionDate BETWEEN @Datefrom
				AND @DateTo
			AND a.CompanyID = @Compid
		GROUP BY e.AccountID
			,a.AccountName
		)

             select * from cte
END
GO
/****** Object:  StoredProcedure [dbo].[TrialBalance_1]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[TrialBalance_1] @Datefrom DATETIME
	,@DateTo DATETIME
	,@compid VARCHAR(50)
AS
BEGIN
	
	create table #temp (AccountID bigint	,AccountName varchar (100),AccountType varchar (100),Debit varchar (100),Credit varchar (100))
	;WITH cte
	AS (
		SELECT e.AccountID
			,a.AccountName , a.AccountType
			,SUM(CASE
					WHEN e.EntryType = 'D'
						THEN e.amount
					ELSE 0.0
					END) AS TotalDebit
			,SUM(CASE
					WHEN e.EntryType = 'C'
						THEN e.amount
					ELSE 0.0
					END) AS TotalCredit
		FROM Transactions t
		LEFT JOIN ledger_entries e ON e.TransactionID = t.id
		LEFT JOIN Accounts a ON a.id = e.AccountID
	WHERE
		t.TransactionDate BETWEEN @Datefrom
			AND @DateTo
		AND a.CompanyID = @compid
		GROUP BY e.AccountID
			,a.AccountName , a.AccountType
		)  
		--,ctee as (
		insert into #temp (AccountID	,AccountName,AccountType,Debit,Credit)
		select AccountID	,AccountName,AccountType,
	case when 	AccountType  in ('Assets' , 'Equity' , 'Expenses')  then (TotalDebit  - TotalCredit) else 0.0 end as Debit,
    case when 	AccountType  in ('Liabilities' , 'Income' )         then (TotalCredit - TotalDebit)  else 0.0 end as Credit
	 from cte


	begin 
		 update #temp 
		 set Credit = Debit  , debit = Credit
		 where AccountType  in ('Assets' , 'Equity' , 'Expenses')  and sign (Debit)= -1  

		  update #temp 
		 set Debit  = Credit  , Credit = Debit
		 where AccountType  in ('Liabilities' , 'Income' )   and sign (Credit)= -1  
	 end 
		 select AccountID	,AccountName,AccountType,  
		 --(Debit)Debit , (Credit)Credit 
		 case when  sign (Debit)= -1   then abs( Debit ) else  Debit end as Debit , 		 case when  sign (Credit)= -1   then abs( Credit ) else  Credit end as Credit 

		 from  #temp
		 drop table #temp
		



	 --,case when AccountType  in ('Liabilities' , 'Income' ) and sign (Credit) = -1 then Credit 

	 --from ctee

	

   
	--order by AccountID

END
GO
/****** Object:  StoredProcedure [dbo].[Vendors_Balance]    Script Date: Saturday, 11-Mar-2023 11:55:44 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

CREATE PROCEDURE [dbo].[Vendors_Balance] @Datefrom DATETIME
	,@DateTo DATETIME
	--,@id BIGINT
	,@compid VARCHAR(50)
AS
BEGIN
	

	WITH cte
	AS (
		SELECT e.AccountID
			,a.AccountName
			,SUM(CASE 
					WHEN e.EntryType = 'D'
						THEN e.amount
					ELSE 0.0
					END) AS TotalDebit
			,SUM(CASE 
					WHEN e.EntryType = 'C'
						THEN e.amount
					ELSE 0.0
					END) AS TotalCredit
		FROM Transactions t
		LEFT JOIN ledger_entries e ON e.TransactionID = t.id
		LEFT JOIN Accounts a ON a.id = e.AccountID
		WHERE t.TransactionDate BETWEEN @Datefrom
				AND @DateTo
			AND a.CompanyID = @Compid
			and a.AccountHead = 'Trade Creditors'
		GROUP BY e.AccountID
			,a.AccountName
		)

             select AccountID , AccountName , TotalCredit - TotalDebit as Balance from cte
END
GO
USE [master]
GO
ALTER DATABASE [Account_Finance] SET  READ_WRITE 
GO
