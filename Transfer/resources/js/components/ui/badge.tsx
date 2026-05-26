import { Slot } from "@radix-ui/react-slot"
import { cva, type VariantProps } from "class-variance-authority"
import * as React from "react"

import { cn } from "@/lib/utils"

const badgeVariants = cva(
  "inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-error/20 aria-invalid:border-error transition-[color,box-shadow] overflow-hidden",
  {
    variants: {
      variant: {
        default:
          "border-transparent bg-primary text-text-inverse [a&]:hover:bg-primary-hover",
        secondary:
          "border-transparent bg-bg-surface text-text-primary [a&]:hover:bg-bg-app",
        destructive:
          "border-transparent bg-error text-text-inverse [a&]:hover:bg-error/90 focus-visible:ring-error/20",
        error:
          "border-transparent bg-error-light text-error",
        success:
          "border-transparent bg-success-light text-success",
        warning:
          "border-transparent bg-warning-light text-warning",
        info:
          "border-transparent bg-info-light text-info",
        outline:
          "text-text-primary border-border [a&]:hover:bg-bg-app",
      },
    },
    defaultVariants: {
      variant: "default",
    },
  }
)

function Badge({
  className,
  variant,
  asChild = false,
  ...props
}: React.ComponentProps<"span"> &
  VariantProps<typeof badgeVariants> & { asChild?: boolean }) {
  const Comp = asChild ? Slot : "span"

  return (
    <Comp
      data-slot="badge"
      className={cn(badgeVariants({ variant }), className)}
      {...props}
    />
  )
}

export { Badge, badgeVariants }
