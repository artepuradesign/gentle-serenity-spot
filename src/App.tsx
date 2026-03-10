import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { Toaster } from "@/components/ui/toaster";
import { TooltipProvider } from "@/components/ui/tooltip";
import Index from "./pages/Index.tsx";
import Cadastro from "./pages/Cadastro.tsx";
import Login from "./pages/Login.tsx";
import Admin from "./pages/Admin.tsx";
import Painel from "./pages/Painel.tsx";
import ExtratoExport from "./pages/ExtratoExport.tsx";
import Saldo from "./pages/Saldo.tsx";
import NotFound from "./pages/NotFound.tsx";

const queryClient = new QueryClient();

const App = () => (
  <QueryClientProvider client={queryClient}>
    <TooltipProvider>
      <Toaster />
      <Sonner />
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Index />} />
          <Route path="/cadastro" element={<Cadastro />} />
          <Route path="/login" element={<Login />} />
          <Route path="/painel" element={<Painel />} />
          <Route path="/admin" element={<Admin />} />
          <Route path="/extrato-export" element={<ExtratoExport />} />
          <Route path="/saldo" element={<Saldo />} />
          {/* ADD ALL CUSTOM ROUTES ABOVE THE CATCH-ALL "*" ROUTE */}
          <Route path="*" element={<NotFound />} />
        </Routes>
      </BrowserRouter>
    </TooltipProvider>
  </QueryClientProvider>
);

export default App;
